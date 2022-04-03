<?php

#Array = Variable that holds mutiple values

/*
-Indexed
-Associative
-Muti-dimentional
*/

// Indexed
$people = array('Kevin', 'Jeremy', 'Sara');
echo $people[1]; //Jeremy

$ids = array(23, 55, 12);
$cars = ['Honda', 'Toyota', 'Ford'];
$cars[3] = 'Tesla';
$cars[] = 'BMW'; //เพิ่มต่อท้าย


echo $cars[0]; //Honda
echo $cars[3]; //Tesla
echo $cars[4]; //BMW

print_r($cars);  //สำหรับแสดงค่า array ทั้งหมด
var_dump($cars); //สำหรับแสดงค่า array ทั้งหมด พร้อม string's length

//Associate arrays
$people2 = array('Brad' => 35, 'Jose' => 32, 'William' => 37); //ทำให้อยู่ในรูป key และ value


echo $people2['Brad'];  //22  แสดง value ของ Brad

$ids = [22 => 'Brad', 44 => 'Jose', 63 => 'William']; //สลับ key เป็น value
echo $ids[22]; //Brad

$people2['Jill'] = 42; //เพิ่ม Jill, 42 ใน $people2
echo $people2['Jill'];

print_r($people2);

//Muti-Dimentional  array หลายมิติ
$cars2 = array(
			array('Honda', 20, 10),  //0,0 0,1 0,2
			array('Totota', 30, 20), //1,0 1,1 1,2
			array('Suzuki', 23, 12)  //2,0 2,1 2,2
		);

echo $cars2[1][0];  //Toyota
?>