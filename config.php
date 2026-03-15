<?php
/**
 * ไฟล์เชื่อมต่อฐานข้อมูลสำหรับระบบยืม-คืน (Borrowing System)
 * ปรับแต่งสำหรับใช้งานร่วมกับ Docker Compose
 */

// 1. กำหนดค่าการเชื่อมต่อ (ให้ตรงกับ service 'db' ใน docker-compose.yml)
$host     = 'db';              // ชื่อ Service ของ Database ใน Docker
$dbname   = 'borrowings_db';   // ชื่อ Database (ตรวจสอบให้ตรงกับ MYSQL_DATABASE)
$username = 'dev_user';        // ชื่อ User (ตรวจสอบให้ตรงกับ MYSQL_USER)
$password = 'dev_password';    // รหัสผ่าน (ตรวจสอบให้ตรงกับ MYSQL_PASSWORD)
$charset  = 'utf8mb4';         // รองรับภาษาไทยและ Emoji

// 2. กำหนด Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// 3. กำหนด Options เพิ่มเติมสำหรับ PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ให้พ่น Error ออกมาเมื่อคำสั่ง SQL ผิด
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // ให้ดึงข้อมูลเป็น Array แบบชื่อคอลัมน์
    PDO::ATTR_EMULATE_PREPARES   => false,                  // ใช้ Prepared Statements จริงเพื่อความปลอดภัย (SQL Injection)
];

try {
    // 4. เริ่มการเชื่อมต่อ
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // หากต้องการทดสอบว่าเชื่อมต่อได้ไหม (ตอนใช้งานจริงให้ลบบรรทัดล่างนี้ออก)
    // echo "Database connection successful!"; 

} catch (PDOException $e) {
    // 5. จัดการกรณีเชื่อมต่อล้มเหลว
    // บันทึก Log หรือแสดงข้อความ Error
    error_log($e->getMessage());
    die("ขออภัย: ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้ (" . $e->getMessage() . ")");
}

