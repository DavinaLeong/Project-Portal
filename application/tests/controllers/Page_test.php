<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Page_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 15 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Page_test extends TestCase
{
    const DO_ECHO = TRUE;

    public function setUp()
    {
        $this->resetInstance();
    }

    public function test_index()
    {
        if($this::DO_ECHO) echo "\n+++ test_index +++\n";

        $output = $this->request('GET', 'page/index');
        $this->assertResponseCode(200);
        $this->assertContains('Project Portal', $output);
    }

} //end Page_test class