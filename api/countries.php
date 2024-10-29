<?php
function getCountries() {
    $file = __DIR__ . "/data/country_continents.json";
    $file_contents = file_get_contents($file);
    return json_decode($file_contents, true);
}

function getContinents() {
    $file = __DIR__ . "/data/continent_codes.json";
    $file_contents = file_get_contents($file);
    return json_decode($file_contents, true);
}

function checkContinentCode($ccode) {
    return (in_array($ccode, array_keys(getContinents())));
}

function getCountriesCode() {
    $file = __DIR__ . "/data/country_codes.json";
    $file_contents = file_get_contents($file);
    return json_decode($file_contents, true);
}
// Fonction pour vérifier si un code de pays est valide
function checkCountriesCode($pcode) {
    $countries = getCountriesCode();
    // Vérifiez si le code fourni existe dans le tableau
    foreach ($countries as $countryArray) {
        foreach ($countryArray as $country => $code) {
            if ($pcode === $code) { // Utiliser === pour une comparaison stricte
                return true; // Code trouvé
            }
        }
    }
    return false; // Code non trouvé
}


function getCountryNameByCode($countriesArray, $countryCode) {
    foreach ($countriesArray as $countryData) {
        foreach ($countryData as $country => $code) {
            if ($code === $countryCode) {
                return $country; // Retourner le nom du pays si le code correspond
            }
        }
    }
    return null; // Retourner null si aucun pays n'est trouvé
}

// Récupérer les paramètres de la requête
$version = $_GET["version"] ?? null;
$controller = $_GET["controller"] ?? null;
$method = $_GET["method"] ?? null;
$ccode = $_GET["ccode"] ?? ($_POST["ccode"] ?? false);
$format = $_GET["format"] ?? "json";

if ($controller === "countries" && $method === "list" && $ccode) {
    if (!checkContinentCode($ccode)) {
        http_response_code(400);
        echo json_encode(["error" => "Code de continent invalide"]);
        exit();
    }

    $countries = getCountries();
    $filteredCountries = array_filter($countries, function($country) use ($ccode) {
        return $country['continent'] === getContinents()[$ccode];
    });


    $response = array_map(function($country) {
        global $ccode;
        return [
            "code" => $ccode,
            "nom" => $country["country"]
        ];
    }, $filteredCountries);

    // Réindexer le tableau pour éviter les trous dans les indices
    $response = array_values($response);
    // Utiliser la fonction format existante
    echo format($response);
    exit();

}
if ($controller === "countries" && $method === "read" && $ccode && $pcode) {
    if (!checkContinentCode($ccode)  ) {
        http_response_code(400);
        echo json_encode(["error" => "Code de continent  invalide"]);
        exit();
    }
    if (!checkCountriesCode($pcode)  ) {
        http_response_code(400);
        echo json_encode(["error" => "Code de pays ou pays invalide"]);
        exit();
    }

    // Inverser le tableau pour avoir le code comme clé
    $continent=getContinents()[$ccode];
    $country = getCountryNameByCode(getCountriesCode(),$pcode);
    $countries= getCountries();

    // Filtrer les pays en fonction du continent et du nom du pays
    $response = array_filter($countries, function($countryData) use ($continent, $country) {
        return isset($countryData['continent']) && $countryData['continent'] === $continent &&
               isset($countryData['country']) && $countryData['country'] === $country   ;
    });

    echo format($response);
        exit();
}

//je n'arrive pas a ajouter le nom du continent dans le fichier country_continents.json
if ($controller === "countries" && $method === "create") {
    // Récupérer le code du continent depuis l'URL
    $continentCode = $_GET["ccode"] ?? null; // Code du continent depuis l'URL
    // Récupérer les paramètres de la requête pour le nouveau pays
    $countryCode = $_POST["pcode"] ?? null; // Code du pays
    $countryName = $_POST["pname"] ?? null; // Nom du pays

    // Vérifier si le code du continent est valide
    if (!checkContinentCode($continentCode)) {
        echo json_encode(["error" => "country creation: invalid continent code"]);
        http_response_code(400);
        exit();
    }
    
    // Vérifier si le code du pays existe déjà
    if (checkCountriesCode($countryCode)) {
        echo json_encode(["error" => "country creation: country code already exists"]);
        http_response_code(400);
        exit();
    }

    // Récupérer les pays existants
    $countries = getCountriesCode(); 
    
    $newId = max(array_keys($countries)) + 1;

    // Ajouter le nouveau pays avec la structure correcte
    $countries[$newId] = [
        $countryName => $countryCode
    ];

    // Sauvegarder les pays dans le fichier
    $file1 = __DIR__ . "/data/country_codes.json"; // Chemin vers votre fichier JSON pour les codes des pays
    file_put_contents($file1, json_encode($countries, JSON_PRETTY_PRINT));
    
    // Récupérer les données existantes du fichier country_continents.json
    $countryContinents = json_decode(file_get_contents(__DIR__ . "/data/country_continents.json"), true) ?? [];
    // Créer la structure pour le fichier country_continents.json
      $countryData = [
        "country" => $countryName,
        "continent" => getCountryNameByCode(getCountriesCode(),$continentCode) // Obtenez le nom du continent par son code
    ];
    // Ajouter le nouveau pays à la liste des pays et continents
    $countryContinents[] = $countryData;

    // Sauvegarder les données des pays et continents
    $file2 = __DIR__ . "/data/country_continents.json"; // Chemin vers votre fichier JSON pour les pays et continent
    file_put_contents($file2, json_encode($countryContinents, JSON_PRETTY_PRINT));

    // Réponse de succès
    echo json_encode(["success" => "Country added successfully."]);
    exit();
}



if ($controller === "countries" && $method === "update") {
    // Récupérer les paramètres de la requête pour mettre à jour le pays
    $countryCode = $_GET["pcode"] ?? null; // Code du pays à mettre à jour
    $newCountryName = $_POST["pname"] ?? null; // Nouveau nom du pays

    // Charger les pays depuis le fichier JSON
    $file = __DIR__ . "/data/country_codes.json";
    $countries = json_decode(file_get_contents($file), true);

    // Vérifier si le code du pays existe
    foreach ($countries as $index => $country) {
        if (reset($country) === $countryCode) { // reset() pour obtenir la valeur du tableau associatif
            // Mettre à jour le nom du pays
            $countries[$index] = [$newCountryName => $countryCode]; // Remplace l'objet entier
            break;
        }
    }

    if (!checkCountriesCode($countryCode)) {
        echo json_encode(["error" => "country update: country code doesn't exist"]);
        http_response_code(400);
        exit();
    }

    // Sauvegarder les pays dans le fichier
    if (file_put_contents($file, json_encode($countries, JSON_PRETTY_PRINT)) === false) {
        echo json_encode(["error" => "Unable to save countries"]);
        http_response_code(400);
        exit();
    }

    // Réponse de succès
    echo json_encode(["success" => "Country updated successfully."]);
    exit();
}
if ($controller === "countries" && $method === "delete") {
    // Récupérer les paramètres de la requête
    $ccode = isset($_GET['ccode']) ? $_GET['ccode'] : null; // Code du pays à supprimer
    $pcode = isset($_GET['pcode']) ? $_GET['pcode'] : null; // Code du produit à supprimer

    // Vérification des paramètres
    if ($ccode && $pcode) {
        // Chemins vers vos fichiers JSON
        $file1 = 'data/country_codes.json';
        $file2 = 'data/country_continents.json';

        // Lire et décoder les fichiers JSON
        $data1 = json_decode(file_get_contents($file1), true);
        $data2 = json_decode(file_get_contents($file2), true);

        // Filtrer les données pour supprimer le pays
        $data1 = array_filter($data1, function($country) use ($pcode) {
            return reset($country) !== $pcode; // Suppression basée sur le code du pays
        });

        // Suppression du produit associé basé sur le nom du pays
        $countryNameToDelete = getCountryNameByCode(getCountriesCode(), $pcode);
        
        $data2 = array_filter($data2, function($product) use ($countryNameToDelete) {
            return $product['country'] !== $countryNameToDelete; // Suppression basée sur le nom du pays
        });

        // Enregistrer les modifications dans les fichiers JSON
        file_put_contents($file1, json_encode(array_values($data1), JSON_PRETTY_PRINT));
        file_put_contents($file2, json_encode(array_values($data2), JSON_PRETTY_PRINT));

        // Répondre avec un message de succès
        echo json_encode(["message" => "Le pays et son produit ont été supprimés avec succès."]);
    } else {
        echo json_encode(["message" => "Paramètres manquants."]);
    }
}
