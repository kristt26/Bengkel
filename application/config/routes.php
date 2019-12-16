<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['API'] = 'Rest_server';

// User API Routes
// $route['api/user/add'] = 'Users/add_user';
// $route['api/users/all'] = 'Users/fetch_all_users';
// $route['api/users/register'] = 'api/Users/register';
// $route['api/users/login'] = 'api/Users/login';
// $route['api/users/UbahPassword'] = 'api/Users/changepassword';
// $route['api/users/UbahUsername'] = 'api/Users/changeuser';
// $route['api/jadwal/jadwalmahasiswa'] = 'api/Jadwal/jadwalMahasiswa';
// $route['api/jadwal/jadwaldosen'] = 'api/Jadwal/JadwalDosen';
// $route['api/jadwal/jadwalall'] = 'api/Jadwal/jadwalall';
// $route['api/jadwal/jadwalKuliah'] = 'api/Jadwal/JadwalKuliah';
// $route['api/krsm/pengajuanKRS'] = 'api/Krsm/pengajuanKRS';
// $route['api/krsm/getkrsmtem'] = 'api/Krsm/ambilTemkrsm';
// $route['api/krsm/putkrsmtem'] = 'api/Krsm/approvedKrsm';
// $route['api/krsm/deleteitem'] = 'api/Krsm/HapusItem';
// $route['api/krsm/insertitem'] = 'api/Krsm/InsertItem';
// $route['api/krhm/GetKemajuanStudi'] = 'api/Khsm/GetKhsm';
// $route['api/krhm/GetIPK'] = 'api/Khsm/AmbilIPK';
// $route['api/profile/GetProfile'] = 'api/Profile/GetProfile';
// $route['api/profile/UpdateProfile'] = 'api/Profile/UpdateProfile';
// $route['api/home/getHome'] = 'api/Home/ambilinfo';
// $route['api/tahunakademik/getTaAktif'] = 'api/TahunAkademik/TAAktif';
// $route['api/approvedkrsm/GetHistori'] = 'api/ApprovedKrsm/ambilHistori';
// $route['api/sksMahasiswa/AmbilSks'] = 'api/SksMahasiswa/GetSKS';
// $route['api/Mahasiswa/GetDataMahasiswa'] = 'api/Mahasiswa/GetMahasiswa';
// $route['api/Perwalian/GetMahasiswa'] = 'api/Perwalian/MahasiswaWali';
// $route['api/KrsmMahasiswa/GetKrsmMahasiswa'] = 'api/KrsmMahasiswa/GetAll';


// Api User
$route['api/User/Registrasi'] = 'api/Users/register';
$route['api/User/Login'] = 'api/Users/login';
// Api Debitur
$route['api/Debitur']['post'] = 'api/Debitur/insert';
$route['api/Debitur']['get'] = 'api/Debitur/select';
$route['api/Debitur/(:num)']['put'] = 'api/Debitur/update/$1';
$route['api/Debitur/(:num)']['delete'] = 'api/Debitur/hapus/$1';
// Api Kriteria
$route['api/Kriteria']['post'] = 'api/Kriteria/insert';
$route['api/Kriteria']['get'] = 'api/Kriteria/select';
$route['api/Kriteria/(:num)']['put'] = 'api/Kriteria/update/$1';
$route['api/Kriteria/(:num)']['delete'] = 'api/Kriteria/hapus/$1';
// Api Persyaratan
$route['api/Persyaratan']['post'] = 'api/Persyaratan/insert';
$route['api/Persyaratan']['get'] = 'api/Persyaratan/select';
$route['api/Persyaratan/(:num)']['put'] = 'api/Persyaratan/update/$1';
$route['api/Persyaratan/(:num)']['delete'] = 'api/Persyaratan/hapus/$1';
// Api Data Kriteria
$route['api/DataKriteria']['post'] = 'api/DataKriteria/insert';
$route['api/DataKriteria']['get'] = 'api/DataKriteria/select';
$route['api/DataKriteria/(:num)']['put'] = 'api/DataKriteria/update/$1';
$route['api/DataKriteria/(:num)']['delete'] = 'api/DataKriteria/hapus/$1';
// Api Data Persyaratan
$route['api/DataPersyaratan']['post'] = 'api/DataPersyaratan/insert';
$route['api/DataPersyaratan']['get'] = 'api/DataPersyaratan/select';
$route['api/DataPersyaratan/(:num)']['put'] = 'api/DataPersyaratan/update/$1';
$route['api/DataPersyaratan/(:num)']['delete'] = 'api/DataPersyaratan/hapus/$1';
// Sub Kriteria
$route['api/SubKriteria']['post'] = 'api/SubKriteria/insert';
$route['api/SubKriteria']['get'] = 'api/SubKriteria/select';
$route['api/SubKriteria/(:num)']['put'] = 'api/SubKriteria/update/$1';
$route['api/SubKriteria/(:num)']['delete'] = 'api/SubKriteria/hapus/$1';
// Periode
$route['api/Periode']['post'] = 'api/Periode/insert';
$route['api/Periode']['get'] = 'api/Periode/select';
$route['api/Periode/(:num)']['put'] = 'api/Periode/update/$1';
$route['api/Periode/(:num)']['delete'] = 'api/Periode/hapus/$1';