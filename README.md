Nama: 
-Shafira  (Backend)
Apa perbedaan Mock dan API nyata?
Jawab:
Mock adalah data tiruan (JSON dummy) yang dibuat FE di sisi browser untuk meniru respons API, supaya FE bisa dikerjakan tanpa menunggu BE selesai. API nyata adalah endpoint Laravel yang benar-benar berjalan, memakai database dan Sanctum.

Nama field mock berbeda dari API (misalnya due_date vs deadline)
Bentuk respons berbeda (mock mengembalikan array langsung, API membungkusnya di data)
Mock tidak punya validasi, sedangkan API mengembalikan 422
Mock tidak menolak request tanpa token, sedangkan API mengembalikan 401
Status code atau format tanggal berbeda
