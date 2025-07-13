# pratama.unggul-nosql
 🏥 Sistem Manajemen Klinik “Pratama Unggul”

Sistem manajemen klinik berbasis MongoDB dan Neo4j untuk mendukung pengelolaan data pasien, rekam medis, obat, dan transaksi pembayaran.

📦 Kode Sumber
mongo_prototype.php: Prototype pada sistem klinik.
Klinik_Pratama_Unggul: Berisi database sistem untuk klinik.

 📁 Isi Repository
- `database/`: Folder berisi data sample JSON untuk MongoDB dan script Cypher untuk Neo4j.
- `src/`: Script PHP untuk insert dan query data pada MongoDB.
- `README.md`: Dokumentasi proyek.
  
 🧰 Teknologi yang Digunakan

- MongoDB (Document-Oriented)
- Neo4j (Graph-Oriented)
- PHP + MongoDB Driver
- MongoDB Compass
- Neo4j Aura / Desktop

🔧 Cara Menjalankan

1. Clone repository:
    ```bash
    git clone https://github.com/pratama.unggul-nosql.git
    ```

2. Pastikan sudah menginstall:
    - MongoDB lokal (`mongodb://localhost:27017`)
    - Neo4j Desktop / Neo4j Aura
    - PHP 7+ dan Composer

3. Jalankan script insert data di folder `src/php/`.

4. Buka MongoDB Compass untuk cek data atau jalankan query MongoDB yang ada di `database/mongodb/queries/`.

5. Import script `.cypher` ke Neo4j Desktop atau Neo4j Aura untuk melihat graf relasi.

 📊 Contoh Query

- Mencari pasien dengan NIK tertentu
- Menampilkan rekam medis oleh dokter
- Query Cypher: 
    ```cypher
    MATCH (d:User {level:"DOKTER"})<-[:DITANGANI_OLEH]-(rm:RekamMedis)-[:MEMILIKI]-(p:Pasien)
    RETURN p.nama_lengkap, d.nama_user, rm.diagnosis
    ```

## 👥 Anggota Kelompok

- Muh. Yusuf Rahman (222181)
- Bryan Onibala (222365)
- Nobel Tandek (222366)
- Clarissa Putri (222370)
- Rika Zhahirah (222373)
- Reski Fahreza (222388)
- Rezky Fadliah Wahda (222413)
- Fitriah Nabila Putri Tamar (222420)
