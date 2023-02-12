<?php
require_once 'function.php';

$data = new rajaongkir();
// Mengambil data kota
$kota = $data->get_city();

//Konversi JSON menjadi array
$kota_array = json_decode($kota, true);


//cara cek error
// print_r($kota_array);
// die();   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-check-ongkir.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!--Untuk memasukan ID Kota Asal dan ID Kota Tujuan-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">
    <title>Cek Ongkir</title>
</head>
<body>
    <header>
        <nav class="head-co">
            <div class="container flex">
                <a href="index.html"><img src="assets/cek-ongkir/arrow-left.png" alt=""></a>
                <h1>Cek Ongkir</h1>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <form action="" id="form-cek-ongkir">
                <img src="assets/cek-ongkir/Ninja Xpress Logo .png" alt="">
                <div class="destination">
                    <select name="kota_asal" id="kota_asal">
                        <option value=""></option>
                        <?php foreach ($kota_array["rajaongkir"]["results"] as $key => $value) : ?>
                            <option value="<?= $value["city_id"]; ?>"><?= $value["city_name"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="kota_tujuan" id="kota_tujuan">
                        <option value=""></option>
                        <?php foreach ($kota_array["rajaongkir"]["results"] as $key => $value) : ?>
                            <option value="<?= $value["city_id"]; ?>"><?= $value["city_name"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="weight flex">
                        <input type="number" placeholder="1.00" id="berat" name="berat" min="1" max="30000"><p>GR</p>
                        <button>+</button>
                        <button>-</button>
                    </div>
                    <p>Dimensi</p>
                    <div class="dimensi flex">
                        <input type="number" placeholder="Panjang CM" name="long" id="LONG" >
                        <input type="number" placeholder="Lebar CM" name="wide" id="WIDE">
                        <input type="number" placeholder="Tinggi CM" name="high" id="HIGH">
                    </div>
                    <p class="weight-volume">Berat Volume : <span></span>KG</p>
                    <div class="btn-search">
                        <button type="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <div class="col-md-8 container">
                <div class="card">
                    <div class="card-header" id="hasil-pengecekan">
                        Hasil Pengecekan
                    </div>
                    <div class="card-body">
                        <table id="tabel-hasil-pengecekan" class="display">
                            <thead>
                                <tr class="panel-body">
                                    <th width="1%">No</th>
                                    <th>Kurir</th>
                                    <th>Jenis Layanan</th>
                                    <th>Tarif</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
    $('#kota_asal').select2({
        placeholder: 'Pilih Kota Asal',
        theme: "bootstrap",
    });

    $('#kota_tujuan').select2({
        placeholder: 'Pilih Kota Tujuan',
        theme: "bootstrap"
    });

    $('#form-cek-ongkir').on('submit', function(e) {
            e.preventDefault(); 

            let kota_asal = $('#kota_asal').select2('data')[0].text;
            let kota_tujuan = $('#kota_tujuan').select2('data')[0].text;
            let berat = $('#berat').val();

            $('#hasil-pengecekan').html(`Hasil Pengecekan <b>${kota_asal}</b> ke <b>${kota_tujuan}</b> @${berat} gram`);

            hasil_pengecekan();
        });

        function hasil_pengecekan() {
            $('#tabel-hasil-pengecekan').DataTable({
                processing: true, //untuk menampilkan tulisan processing nya
                serverSide: true, //
                bDestroy: true, //saat data table di panggil kembali, dia akan mendestroy data nya
                responsive: true,
                ajax: {
                    url: 'cost.php',
                    type: 'POST',
                    data: {
                        kota_asal: $('#kota_asal').val(),
                        kota_tujuan: $('#kota_tujuan').val(),
                        berat: $('#berat').val(),
                    },
                    complete: function(data) {
                        resetForm('form-cek-ongkir', ['kota_asal', 'kota_tujuan']);
                    } //jika prosesnya complete maka form akan te-reset
                }

            });
        }

        function resetForm(form, select2 = []) {
            $('#' + form)[0].reset();
            if (select2.length > 0) {
                $.each(select2, function(k, v) {
                    $('#' + v).val('').trigger('change');
                });
            }
        }
</script>
</body>
</html>