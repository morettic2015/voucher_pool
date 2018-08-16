<?php

use Medoo\Medoo;

/**
 * @Class to manage database rules
 * @author <projetos@morettic.com.br>
 * */
class PersistenceManager {

    const DATABASE = "voucher_pool";
    const USERNAME = "voucher";
    const PASSWORD = "V@uch3rP00l_123";
    const CONNECTION = "localhost";
    const DRIVER = 'mysql';

    private $conn;

    /**
     * @see Medoo component
     * @Init database connection
     * */
    function __construct() {
        $this->conn = new Medoo([
            'database_type' => self::DRIVER,
            'database_name' => self::DATABASE,
            'server' => self::CONNECTION,
            'username' => self::USERNAME,
            'password' => self::PASSWORD
        ]);
    }
    /**
     * @Get connection
     * @return Mysql Connection from MEdoo framework
    */
    public function getConn(){
        return $this->conn;
    }

    /**
     * Extra: For a given Email, return all his valid Voucher Codes with the Name of the Special Offer
     * @param $email recipient email
     * @return a list of valid vouchers
     * */
    public function listVoucherByEmail($email) {
        $query = "  SELECT 
                        a.token as token, a.id_voucher_code  as id
                    FROM voucher_code as a left join recipient on id_recipient = fk_recipient
                    where 
                        email like '$email'  
                        and a.activation_date is null 
                        and expiration >= now()";
        return $this->conn->query($query)->fetchAll();
    }

    /**
     * @Get a list of recipients and generate vouchers
     * @param $offerID OFFER PK
     * @param $date Offer date limit
     * @return Status 201 sucess or error message
     * */
    public function generateVouchers($offerID, $date) {
        $ret = [];
        $recipients = $this->conn->select('recipient', ['id_recipient']);

        foreach ($recipients as $r) {
            $token = $this->generateToken($offerID, $r['id_recipient']);
            $this->conn->insert("voucher_code", [
                "token" => $token,
                "expiration" => $date,
                "fk_recipient" => $r['id_recipient'],
                "fk_special_offer" => $offerID,
            ]);
            //Get voucher ID 
            $voucher_id = $this->conn->id();
            $std = new stdClass();
            $std->voucher_id = $voucher_id;
            $std->recipient_id = $r['id_recipient'];
            $ret[] = $std;
        }
        return $ret;
    }

    /**
     * Provide an endpoint, reachable via HTTP, which receives a Voucher Code and Email 
     * and validates the Voucher Code. In Case it is valid, return the Percentage Discount
     * and set the date of usage
     * @param $voucherID pk from voucher
     * @param $email email from recipient
     * @return voucher or error
     * */
    public function validateVoucherCode($voucherID, $email) {
        $voucher = $this->conn->select("voucher_code", ["id_voucher_code", "fk_special_offer"], [//Where match conditions for voucher pool
            "id_voucher_code[=]" => $voucherID,
            "enabled[=]" => 1, //its enabled
            "expiration[<=]" => 'now()'//didnt expired
        ]);
        if (count($voucher) > 0) {//Voucher is valid 
            //echo $voucher[0]['fk_special_offer'];
            $recipient = $this->conn->select("recipient", ["id_recipient"], ["email[=]" => $email]);
           // var_dump($recipient);die;
            $offer = $this->conn->select("special_offer", ["discount"], ["id_special_offer[=]" => $voucher[0]['fk_special_offer']]);
            //Update voucher Status
            $this->conn->update("voucher_code", ['enabled' => '0', 'activation_date' => date("y-m-d")], ["id_voucher_code" => $voucher[0]['id_voucher_code']]
            ); //return offer discount
            return $offer;
        } else {
            return ['error' => 'Invalid Voucher or it has expired or has been used...'];
        }
    }

    /**
     * Generates a random 15 str lentgh unique token based on offer, recipient id and date for now
     * @param $offerID pk from offer
     * @param $recipientID id for a given recipient
     * @return str md5 16 char length
     */
    private function generateToken($offerID, $recipientID) {
        return substr(md5($offerID . '_' . date("m.d.y") . '_' . $recipientID), 0, 15);
    }

    /**
     * Get status for view
     * */
    public function getStatus() {
        $query = "select 
                    (select count(*) from voucher_code) as total,
                    (select count(*) from voucher_code)-(select count(*) from voucher_code where enabled = 0 ) as not_used,
                    (select count(*) from voucher_code where enabled = 0 ) as used
                from dual";
        return $this->conn->query($query)->fetchAll();
    }

    /**
     * Get status for view
     * */
    public function getList() {
        $query = "select * from voucher_code as a left join recipient as b on a.fk_recipient = b.id_recipient  order by id_voucher_code asc";
        return $this->conn->query($query)->fetchAll();
    }

}

?>