<?php
include '/var/www/html/codeigniter/application/vendor/autoload.php';

class Fundoo extends TestCase
{

    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/codeigniter/'], array(
            'request.options' => array(
                'exceptions' => false,
            ),
        ));
    }
    public function testRegister(){

        // $file                 = $this->constantClassObj->registrationTestcaseFileName;
        // $data                 = file_get_contents($file, true);
        // $testCaseExampleArray = json_decode($data, true);


        // foreach ($testCaseExampleArray as $key => $value) {

        //     $_POST['firstname']=$value['firstname'];
        //     $_POST['lastname']=$value['lastname'];
        //     $_POST['email'] = $value['email'];
        //     $_POST['phonenum'] = $value['phonenum'];
        //     $_POST['password'] =$value['password'];

        //     $ref                   = new Register();
        //     $result                = $ref->signup();
        //     $res                   = $this->assertEquals($value['expected'], $result);

        // }


        $request = $this->http->post('signup', [
            'form_params' => [
                'firstname'=>'chandu',
                'lastname'=>'shree',
                'email' => 'cdd@gmail.com',
                'phonenum' => '1222223336',
                'password' => '123456789',
            ],
        ]);
        $stream = $request->getBody();
        $contents = json_decode($stream);
        $res = $contents->message;

        if($res=="200"){
            
        }
        $this->assertEquals("200", $res,'Email already exists');  

        
    }
    public function testlogin(){
        $request = $this->http->post('signin',[
            'form_params' => [
                'email'=>'chandra1996jh@gmail.com',
                'password'=>'chandrashree'
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'password incorrect');
    }

    public function testNotes(){
        $request = $this->http->post('setNotes',[
            'form_params' => [
                'email'=>'chandra1996jh@gmail.com',
                'takeANote'=>'ddgfgdf',
                'title'=>'tt',
                'dateAndTime'=>'',
                'color'=>'white',
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'password incorrect');
    }

    public function testReminder(){
        $request = $this->http->post('setReminderNotes',[
            'form_params' => [
                'email'=>'chandra1996jh@gmail.com',
                'takeANote'=>'ddgfgdf',
                'title'=>'tt',
                'dateAndTime'=>'',
                'color'=>'white',
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'password incorrect');
    }
    public function testforgotPasswordFunction(){
        $request = $this->http->post('forgotPassword',[
            'form_params' => [
                'email'=>'chandra1996jh@gmail.com',
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'password incorrect');
    }
    public function testfetchArchive(){
        $request = $this->http->post('fetchArchive',[
            'form_params' => [
                'email'=>'chandra1996jh@gmail.com',
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'success');
    }
    public function testunarchive(){
        $request = $this->http->post('unarchive',[
            'form_params' => [
                'uid'=>'36',
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'success');
    }
    public function testgetAllNotes(){
        $request = $this->http->post('unarchive',[
            'form_params' => [
                'email'=>'chandra1996jh@gmail.com',
            ],
        ]);
        $stream = $request->getbody();
        $contents = json_decode($stream);
        $res = $contents->message;
        $this->assertEquals("200", $res,'success');
    }

}