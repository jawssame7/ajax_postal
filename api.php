<?php

$postalCode = '';

if (empty($_GET['zip_code'])) {
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    $results = [
        'success' => false,
        'results' => [],
        'message' => [
            'パラメータ:zip_code が指定されていません。'
        ]
    ];
    echo json_encode($results);
    return;
} else {
    $postalCode = $_GET['zip_code'];
}


try{
    $addr = 'mysql:host=127.0.0.1; dbname=postal_data';
    $user = 'test';
    $pass = 'test';
    $sql = [
        'SELECT ',
        'zip_code, ',
        'address1, ',
        'address2, ',
        'address3, ',
        'kana1, ',
        'kana2, ',
        'kana3 ',
        'FROM ',
        'postal_codes ',
        'WHERE ',
        'zip_code = :zip_code'
    ];
    //var_dump(implode($sql));
    // 接続
    $pdo = new PDO($addr, $user, $pass);

    $stmt = $pdo->prepare(implode($sql));
    $stmt->execute(['zip_code' => $postalCode]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($row);
    $results = [];
    $ret = [];
    if (!empty($row)) {
        $ret = [
            'zip_code' => $row['zip_code'],
            'address1' => $row['address1'],
            'address2' => $row['address2'],
            'address3' => $row['address3'],
            'kana1' => $row['kana1'],
            'kana2' => $row['kana2'],
            'kana3' => $row['kana3']
        ];
    }
    //var_dump($results);
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    if (!empty($ret)) {
        $results = [
            'success' => true,
            'results' => [
                $ret
            ]
        ];
        echo json_encode($results);
    } else {
        $results = [
            'success' => false,
            'results' => [],
            'message' => [
                '対象のデータがありません。'
            ]
        ];
        echo json_encode($results);
    }
    
    
}catch(PDOException $e){
    echo "database open error: $addr\n $user\n" .
    $e->getMessage();
}
    
    $pdo = NULL;    // 切断
?>