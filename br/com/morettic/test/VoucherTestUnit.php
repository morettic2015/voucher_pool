<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

include_once './br/com/morettic/model/PersistenceManager.php';

/**
 * Description of VoucherTestUnit
 *
 * @author <projetos@morettic.com.br>
 */
final class VoucherTestUnit extends TestCase{
    //put your code here
    /**
     * @test if sum of total used and unsed match
    */
    public function testStatus(){
        $model = new PersistenceManager();
        $stats = $model->getStatus();

        $this->assertEquals(
            intval($stats[0]['total']),
            intval($stats[0]['used'])+intval($stats[0]['not_used'])
        );
    }
    /**
     * @test if database connection is a instance of Medoo class
    */
    public function testDbConn(){
        $model = new PersistenceManager();
       // $conn = $model->getConn();
        $this->assertInstanceOf(
            Medoo\Medoo::class,
            $model->getConn()
        );
        
    }
}
