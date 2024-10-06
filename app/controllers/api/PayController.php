<?php
class PayController extends BaseController{

    private $bookingModel;

    public function __construct()
    {
        $this->model("admin.booking");
        $this->bookingModel = new BookingModel();
    }
    
    public function createPay(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $schedule_id = isset($_POST['schedule_id']) ? $_POST['schedule_id'] : '';
            $room_id = isset($_POST['room_id']) ? $_POST['room_id']  : []; 
            $seats = isset($_POST['seats']) ? explode(',', trim($_POST['seats'], " ")) : [];
            $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : 0;            
            $amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : 0;          
            $orderInfo = isset($_POST['order_info']) ? $_POST['order_info'] : '';
            $bankCode = isset($_POST['bankcode']) ? $_POST['bankcode'] : '';
            $validation = [];
            if(empty($user_id)){
                $validation[] = 'User id is required';
            }
            if(empty($schedule_id)){
                $validation[] = 'Schedule id is required';
            }
            if(empty($seats)){
                $validation[] = 'Seat id is required';
            }
            if(empty($amount)){
                $validation[] = 'Total amount is required';
            }
            if(!empty($validation)){
                $response = json_encode([
                    'status' => 'error',
                    'message' => $validation
                ]);
                echo $response;
            }else{

                $vnp_TxnRef = date("YmdHis");
                $data = [
                    'user_id' => $user_id,
                    'schedule_id' => $schedule_id,
                    'room_id' => $room_id,
                    'seats' => json_encode($seats),
                    'total_amount' => $total_amount,
                    'payment_method' => 'Pending',
                    'transaction_code' => $vnp_TxnRef,
                    'status' => 'Pending'
                ];
                $this->bookingModel->store($data);
                $vnp_TmnCode = "1KGRHQ70";
                $vnp_HashSecret = "BJK22L6IHCHE26ACVQX2X2UTS2UJ1MYS";
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_ReturnUrl = "http://localhost:8800/movieticketbooking/api/pay/vnpayqr";            
                $vnp_OrderInfo = $orderInfo;
                $vnp_OrderType = "billpayment";
                $vnp_Amount = $amount*100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = $bankCode;
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];                  
                $inputData = array(
                    "vnp_Version" => "2.0.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount"  => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode"  => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_ReturnUrl,
                    "vnp_TxnRef"    => $vnp_TxnRef 
                );
                if(isset($vnp_BankCode) && $vnp_BankCode != ""){
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach($inputData as $key => $value){
                    if($i == 1){
                        $hashdata .= '&' . $key . "=" .$value;
                    }else{
                        $hashdata .= $key . "=" . $value;
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urldecode($value) . '&';
                }
                $vnp_Url = $vnp_Url . "?" . $query;
                if(isset($vnp_HashSecret)){
                    $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
                    $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
                }         
                header('Location: '  .$vnp_Url);       
            }
        }
    }
    
    public function vnpayQr(){
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            $vnp_TmnCode = isset($_GET['vnp_TmnCode']) ? $_GET['vnp_TmnCode'] : '';
            $vnp_TxnRef = isset($_GET['vnp_TxnRef']) ? $_GET['vnp_TxnRef'] : '';
            $vnp_SecureHashType = isset($_GET['vnp_SecureHashType']) ? $_GET['vnp_SecureHashType'] : '';
            $vnp_SecureHash = isset($_GET['vnp_SecureHash']) ? $_GET['vnp_SecureHash'] : '';
            $vnp_HashSecret = "BJK22L6IHCHE26ACVQX2X2UTS2UJ1MYS";

            $inputData = [];
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            unset($inputData['vnp_SecureHash']); 
            ksort($inputData);
            $hashData = "";
            foreach ($inputData as $key => $value) {
                $hashData .= '&' . $key . "=" . $value;
            }
            $hashData = ltrim($hashData, '&'); 
            $secureHash = hash('sha256', $vnp_HashSecret . $hashData);
            if ($secureHash === $vnp_SecureHash) {
                $find = [
                    'transaction_code' => $vnp_TxnRef,                   
                ];
                $booking = $this->bookingModel->findbycondition($find);
                if ($booking) {
                    // $this->bookingModel->updateStatus($vnp_TxnRef, 'Completed');
                    $response = json_encode([
                        'status' => 'success',
                        'message' => 'Payment successfully processed'
                    ]);
                    echo $response;
                } else {
                    $response = json_encode([
                        'status' => 'error',
                        'message' => 'Booking not found'
                    ]);
                    echo $response;
                }
            } else {
                $response = json_encode([
                    'status' => 'error',
                    'message' => 'Invalid secure hash'
                ]);
                echo $response;
            }
        }
        
    }
}
?>