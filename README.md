# Educa Studio School Management System

## Daftar Isi  

- [Educa Studio School Management System](#educa-studio-school-management-system)
  - [Daftar Isi](#daftar-isi)
  - [Deskripsi](#deskripsi)
  - [Contributor](#contributor)
  - [Requirement](#requirement)
  - [Deployment](#deployment)
  - [User Role](#user-role)
  - [View Route](#view-route)
  - [Rest Api Route](#rest-api-route)


## Deskripsi   

Ini adalah dokumentasi Singkat Educa Studio School Management System 

## Contributor  
- Ahmad Catur Yulianto @CaturSkak
- Miku21 @Miku21750
- Khusanda @Khusanda
- Muhammad Najib RB @najibdani21
- Rizqi Pratama @rizqidev

## Requirement

- PHP 7.4 / 8
- Mysql / MariaDB 
- composer

## Deployment 

Production Server / Shared Hosting / Virtual Private Server
- Pointkan root vhost kedalam folder `public` 
- Lalu hubungkan dengan database.

Development Server
- clone
- bila vendornya belum ada ketik `composer update` atau `composer install`
- ketikan perintah `composer start` atau `php -S localhost:8200 -t ./public`

Docker 
- ketikkan perintah `docker compose up` (dokumentasi belum selesai)


## User Role  

| Tipe    | Id Tipe | Deskripsi                                     |
|---------|---------|-----------------------------------------------|
| Student |    1    | Sebagian fungsi/action yang dikhususkan saja. |
| Teacher |    2    | Sebagian fungsi/action yang dikhususkan saja. |
| Admin   |    3    | Semua fungsi/action terbuka                   |
| Parent  |    4    | Sebagian fungsi/action yang dikhususkan saja. |  

<hr>

## View Route

| Tingkatan Akses | Sidebar Menu  | Rute                | Deskripsi                                           |
|-----------------|---------------|---------------------|-----------------------------------------------------|
|     1,2,3,4     |               | /login              | Login                                               |
|      1,2,4      |               | /Register           | Register                                            |
|     1,2,3,4     |               | /                   | Dashboard                                           |
|      1,2,3      | Student       | /all-student        | Melihat Semua Siswa                                 |
|        3        | Student       | /admit-form         | Tambah Siswa (Admission Form)                       |
|      1,2,3      | Teacher       | /all-teacher        | Melihat Semua Guru                                  |
|        3        | Teacher       | /add-teacher        | Menambah Guru                                       |
|        3        | Teacher       | /teacher-payment    | Melihat Gaji Guru                                   |
|        3        | Parent        | /all-parent         | Melihat Seluruh Orang Tua Murid                     |
|        3        | Parent        | /add-parent         | Menambah Orang Tua Murid                            |
|      1,2,3      | Liblary       | /all-book           | Melihat Semua Buku                                  |
|        3        | Liblary       | /add-book           | Menambah Buku                                       |
|        3        | Accoununt     | /all-fees           | Melihat pemasukan                                   |
|        3        | Accoununt     | /all-expense        | Melihat Pengeluaran                                 |
|        3        | Accoununt     | /add-expense        | Menambah Pemasukan Pengeluaran                      |
|      1,2,3      | Class         | /all-class          | Melihat Semua Kelas                                 |
|        3        | Class         | /add-class          | Menambah Kelas Baru                                 |
|       2*,3      | Subject       | /all-subject        | Menambah dan melihat semua Mata Pelajaran           |
|     1*,2*,3     | Class Routine | /class-routine      | Menambah dan melihat semua rutinitas kelas (Jadwal) |
|       2,3       | Attendance    | /student-attendence | Melihat dan menambah absen Siswa                    |
|      1,2,3      | Exam          | /exam-schedule      | Melihat Semua Ujian                                 |
|      1,2,3      | Exam          | /exam-grade         | Melihat Hasil Ujian                                 |
|      1*,2,3     | Exam          | /exam-result        | Melihat dan Menambah hasil ujian                    |
|       1*,3      | Transport     | /transport          | Melihat dan Menambah transport                      |
|       1*,3      | Hostel        | /hostel             | Melihat dan menambah asrama                         |
|      1,2,3      | Messeage      | /messaging          | Pesan                                               |
|    1*,2*,3,4*   | Notice        | /notice-board       | Pemberitahuan                                       |
|        3        | Account       | /all-account        | Melihat Semua Akun                                  |
|        3        | Account       | /add-account        | Menambah Akun Baru                                  |
  
<hr>

## Rest Api Route  
Berikut ini adalalah daftar api yang digunakan :   
untuk pengujian harus ditambahkan parameter input yang dibutuhkan.

Misal :  
Url : 
`{{baseUrl}}/api/kelas/add-kelas`  
Parameter : `{ "kelas": 1, "bagian": 1, "idTeacher": 23, }`  
Hasil :  `{ "status": "success", "details": { "inserted to class": "17", "updated to users": "23"} }`  

*Untuk api yang telah diberi auth harus ditambahkan konfigurasi manual.  
**Untuk Parameter input sedang didokumentasikan.

      '/api',
            '/login',
            '/register'
            '/user',
                    '/account-setting',
            '/admin',
                    '/apidata',
                    '/chart',     
            '/kelas',
                    '/hapus-kelas',
                    '/getallclassdt',
                    '/getallclassS',
                    '/{id}detail',
                    '/updateclass',
            '/library',
                    '/getBook',
                    '/getBookS',
                    '/{id}/book-detail',
                    '/update-book-detail',
                    '/delete-book',
                    '/add-book',
            '/subject',
                    '/{id}/subject-detail',
            '/class-routine',
                    '/{id}/class-routine-detail',
            '/transport',
                    '/getTransport',
                    '/getTransportS',
                    '/{id}/transport-detail',
                    '/update-transport-detail',
                    '/delete-transport',
                    '/add-transport',
            '/hostel',
                    '/getHostel',
                    '/getHostelS',
                    '/{id}/hostel-detail',
                    '/update-hostel-detail',
                    '/delete-hostel',
                    '/add-hostel',
            '/exam',
                    '/getExam',
                    '/getExamS',
                    '/getExamGrade',
                    '/{id}/exam-detail',
                    '/{id}/grade-detail',
                    '/update-exam-detail',
                    '/update-grade-detail',
                    '/delete-exam',
                    '/add-exam',
                    '/add-exam-result',
            '/student',
                    '/apidata',
            '/{id}/examResult',
            '/{id}/select',
            '/{id}/result',
            '/allparents',
            '/allsubject',
            '/addsubject',
            '/deletesubject',
            '/updatesubject',
            '/allclassroutine',
            '/allclassroutine1',
            '/allclassroutineguru',
            '/addclassroutine',
            '/deleteclassroutine',
            '/updateclassroutine',
            '/{id}/detail',
            '/parent-detail/{id}',
            '/update-parent-detail',
            '/delete-parent',
            '/add-parent',
            '/dashboard-teacher',
            '/allstudents',
            '/delete-student',
            '/student-detail/{id}',
            '/update-student-detail',
            '/add-student',
            '/add-promotion',
            '/admission/{id}',
            '/allteachers',
            '/teacher_detail/{id}',
            '/delete-teacher',
            '/update-teacher-detail',
            '/add-teacher',
            '/allpayment',
            '/allfees',
            '/delete-fees',
            '/{id}/payment-detail',
            '/update-payment-detail',
            '/allexpense',
            '/add-payment',
            '/all-result',
            '/delete-result',
            '/{id}/result-detail',
            '/update-result-detail', 
