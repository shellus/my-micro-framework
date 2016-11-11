<?php

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 15:13
 */
class ORMTest extends \PHPUnit_Framework_TestCase
{

    public function testInsert()
    {

        $m = \Sh\ORM::$db->table('navigations')->insert([
            'name' => '新链接(test)',
            'href' => 'http://www.baidu.com',
            'icon' => '',
        ]);
        $this->assertGreaterThan(0, $m, '插入后返回错误的ID');
    }

    public function testUpdate()
    {

        $m = \Sh\ORM::$db->table('navigations')->where([
            [
                'name', '=', '新链接(test)',
            ],
        ])->update([
            'name' => '新新链接(test)',
        ]);
        $this->assertGreaterThan(0, $m, '更新数量错误');
    }

    public function testSelect()
    {
        $m = \Sh\ORM::$db->table('navigations')->where([
            [
                'name', '=', '新新链接(test)',
            ],
        ])->select();

        $this->assertGreaterThan(0, count($m), '查询数量错误');

        foreach ($m as $item){
            $this -> assertNotEmpty($item['id'], '查询到的数据错误');
        }
    }

    public function testDelete()
    {
        $m = \Sh\ORM::$db->table('navigations')->where([
            [
                'name', '=', '新新链接(test)',
            ],
        ])->delete();

        $this->assertGreaterThan(0, count($m), '删除数量错误');
    }
}