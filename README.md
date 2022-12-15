# Educa Studio School Management System

Ini adalah dokumentasi Singkat Educa Studio School Management System 


## Daftar Isi  

- [Educa Studio School Management System](#educa-studio-school-management-system)
  - [Daftar Isi](#daftar-isi)
  - [User Role](#user-role)
  - [Route Documentation](#route-documentation)
  - [Rest Api](#rest-api)
  - [Authors and acknowledgment](#authors-and-acknowledgment)
  - [License](#license)
  - [Project status](#project-status)
  - [Suggestions for a good README](#suggestions-for-a-good-readme)
  - [Name](#name)
  - [Description](#description)
  - [Badges](#badges)
  - [Visuals](#visuals)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Support](#support)
  - [Contributing](#contributing)




## User Role  

| Tipe    | Id Tipe | Deskripsi                                     |
|---------|---------|-----------------------------------------------|
| Student |    1    | Sebagian fungsi/action yang dikhususkan saja. |
| Teacher |    2    | Sebagian fungsi/action yang dikhususkan saja. |
| Admin   |    3    | Semua fungsi/action terbuka                   |
| Parent  |    4    | Sebagian fungsi/action yang dikhususkan saja. |  

## Route Documentation  

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

## Rest Api  
Belum.

## Authors and acknowledgment
Belum.

## License
Company Confedential.

## Project status
On Going.

## Suggestions for a good README
Every project is different, so consider which of these sections apply to yours. The sections used in the template are suggestions for most open source projects. Also keep in mind that while a README can be too long and detailed, too long is better than too short. If you think your README is too long, consider utilizing another form of documentation rather than cutting out information.

## Name
Choose a self-explaining name for your project.

## Description
Let people know what your project can do specifically. Provide context and add a link to any reference visitors might be unfamiliar with. A list of Features or a Background subsection can also be added here. If there are alternatives to your project, this is a good place to list differentiating factors.

## Badges
On some READMEs, you may see small images that convey metadata, such as whether or not all the tests are passing for the project. You can use Shields to add some to your README. Many services also have instructions for adding a badge.

## Visuals
Depending on what you are making, it can be a good idea to include screenshots or even a video (you'll frequently see GIFs rather than actual videos). Tools like ttygif can help, but check out Asciinema for a more sophisticated method.

## Installation
Within a particular ecosystem, there may be a common way of installing things, such as using Yarn, NuGet, or Homebrew. However, consider the possibility that whoever is reading your README is a novice and would like more guidance. Listing specific steps helps remove ambiguity and gets people to using your project as quickly as possible. If it only runs in a specific context like a particular programming language version or operating system or has dependencies that have to be installed manually, also add a Requirements subsection.

## Usage
Use examples liberally, and show the expected output if you can. It's helpful to have inline the smallest example of usage that you can demonstrate, while providing links to more sophisticated examples if they are too long to reasonably include in the README.

## Support
Tell people where they can go to for help. It can be any combination of an issue tracker, a chat room, an email address, etc.

## Contributing
State if you are open to contributions and what your requirements are for accepting them.

For people who want to make changes to your project, it's helpful to have some documentation on how to get started. Perhaps there is a script that they should run or some environment variables that they need to set. Make these steps explicit. These instructions could also be useful to your future self.

You can also document commands to lint the code or run tests. These steps help to ensure high code quality and reduce the likelihood that the changes inadvertently break something. Having instructions for running tests is especially helpful if it requires external setup, such as starting a Selenium server for testing in a browser.

