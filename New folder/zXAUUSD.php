<?php
session_start();
if (!isset($_SESSION["portnumber"])) {
    header("location: login.php");
    exit();
}
?>

<?php
include('connect.php'); 



// เตรียมคำสั่ง SQL สำหรับดึงข้อมูลจากตาราง infouser
$sql = "SELECT portnumber, permission FROM infouser WHERE portnumber = '" . $_SESSION["portnumber"] . "'";
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // วนลูปเพื่อดึงข้อมูลแต่ละแถว
    while($row = $result->fetch_assoc()) {
        $portnumber = $row["portnumber"];
        $permission = $row["permission"];
    }
} else {
    echo "0 results";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/EURUSD.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&family=Prompt:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     
   
    <title>Document</title>

   

</head>

<body>
    <div class="sidebar">
        <ul>
            <li><a href="#"><img src="img/logo.png" alt=""></a></li>
            <li><a href="homepage.php"><i class="fa-solid fa-house"></i><span>Home</span></a></li>
            <li><a href="port.php"><i class="fa-solid fa-wallet"></i><span>Port</span></a></li>
            <li><a href="status.php"><i class="fa-solid fa-check"></i></i><span>Status</span></a></li>
            <li><a href="download.php"><i class="fa-solid fa-download"><span>Dowload</span></i></a></li>
            <li><a href="payment.php"><i class="fa-solid fa-file-invoice-dollar"></i><span>My Bill</span></i></a></li>
        </ul>
    </div>

    <nav>
        <div class="account-info">
            <div class="logoutbut">
                <a href="logout.php" ><i class="fa-solid fa-arrow-right-from-bracket"></i> </a>
            </div>
            <div class="profile-pic">
                <img src="img/acc.PNG" alt="Profile picture">
            </div>
            
            <div class="user-details">
                <p class="port-number">Port: <?php echo $portnumber; ?></p>
                <?php
                    // ตรวจสอบค่าของ $permission เพื่อแสดงข้อความและสีตามเงื่อนไข
                    if ($permission == "ALLOW") {
                        echo '<p class="status" style="color: green;">มีสิทธิเข้าใช้งาน</p>';
                    } elseif ($permission == "pending") {
                        echo '<p class="status" style="color: #E1A12B;">รออนุมัติ</p>';
                    } elseif ($permission == "not allow") {
                        echo '<p class="status" style="color: red;">ไม่มีสิทธิเข้าใช้งาน</p>';
                    } else {
                        echo '<p class="status" style="color: black;">ไม่ทราบสถานะ</p>';
                    }
                ?>
            </div>
        </div>
    </nav>
    <script>
    function getData() {
        var selectedValue = document.getElementById("my-dropdown").value;
        var symbol = selectedValue.split("_")[0]; // แยกค่า symbol
        var timeframe = selectedValue.split("_")[1]; // แยกค่า timeframe
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_data.php?symbol=" + symbol + "&timeframe=" + timeframe, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("table-container").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
    <div class="container">
        <h3>Select Time Frame</h3>
        <select id="my-dropdown" onchange="getData()" >
        <option value="" disabled selected hidden>Time Frame</option>
            <option value="XAUUSD_M15">M15</option>
            <option value="XAUUSD_M30">M30</option>
        </select>
    
        <table  class="tablecontent" id="table-container">
            <thead>
                <tr> 
                    <th>Template</th>
                    <th>Symbol</th>
                    <th>Time Frame</th>
                    <th>Accurate</th>
                    <th>Highperiod</th>
                    <th>Midperiod</th>
                    <th>Lowperiod</th>
                    <th>Lot size mul</th>
                    <th>Num of round</th>
                    
                </tr>
            </thead>
            <tbody>
                <!-- ข้อมูลแถวจะถูกเพิ่มทีหลัง -->
            </tbody>
        </table>
    </div>
    




</body>

</html>
