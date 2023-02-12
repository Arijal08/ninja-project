<?php

class rajaongkir
{
    private $key = "c073655b6e2e079a9c2ac8296621f11a";
    private $city_url = "https://api.rajaongkir.com/starter/city";
    private $cost_url = "https://api.rajaongkir.com/starter/cost";

    
    function array_sort_by_column(&$arr, $col, $dir = SORT_DESC)//Untuk sorting untuk menampilkan dalam data tabel berdasarkan biaya
    {
        $sort_col = [];
        foreach ($arr as $key => $value) {          //perulangan variabel array yang ada pada parameter
            $sort_col[$key] = $value[$col];
        }

        array_multisort($sort_col, $dir, $arr);     //sorting berdasarkan direction yang telah ditentukan
    }

    function get_city()     //mengambil data kota
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->city_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: {$this->key}"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function get_cost($id_kota_asal, $id_kota_tujuan, $berat)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->cost_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin={$id_kota_asal}&destination={$id_kota_tujuan}&weight={$berat}&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: {$this->key}"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
