
<?php
class LoginController {
    private $pdo;
    private $userModel;

    public function __construct() {
        require 'config/database.php';
        $this->pdo = $pdo;
        $this->userModel = new User($this->pdo);
    }

    public function index() {
        require 'views/login.php';
    }

    public function authenticate() {
        $AmilNo = $_POST['AmilNo'];
        $Passworda = $_POST['Passworda'];

        $user    = $this->userModel->login($AmilNo, $Passworda);
        $totalAm = $this->userModel->getTotalAmountUser($AmilNo);
        $totalAi = $this->userModel->getTotalItemsUser($AmilNo);

        if ($user) {
            $_SESSION['AmilNo'] = $user['AmilNo'];
            $_SESSION['AmilName'] = $user['AmilName'];
            $_SESSION['NawRasid'] = $user['NawRasid'];
            $_SESSION['PuyType'] = $user['PuyType'];
            $_SESSION['totalAmount'] = $totalAm;
            $_SESSION['totalItems'] = $totalAi;
            
            header('Location: index.php?controller=main&action=index');
            exit();
        } else {
            $error = "رقم العميل أو كلمة السر غير صحيحة.";
            require 'views/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }
}
?>
