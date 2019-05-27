<?php // callback.php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";
require_once('setting.php');
require_once('fn.php');

///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\AccountLinkEvent;
use LINE\LINEBot\Event\MemberJoinEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');

// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
$replyData = NULL;
$replyToken = NULL;
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    $userMessage = strtolower($userMessage);
    switch ($typeMessage){
        case 'text':
            switch ($userMessage) {
                case "fix":
                    $url = 'https://itddc.herokuapp.com/api.php';
                    $data = call_api($url);
                    foreach ($data as $value) {
                      $text_test[] = $value->id.'<>'.$value->fixdetail;
                    }
                    $text2 = add_comma($text_test);
                    $textReplyMessage = $text2;
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
					
				case "ntip":
                    $textReplyMessage = "ntip ย่อมาจาก national tuberculosis information program";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "เว็บไซต์":
                    $textReplyMessage = "https://tbcmthailand.ddc.moph.go.th/uiform/login.aspx";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "website":
                    $textReplyMessage = "https://tbcmthailand.ddc.moph.go.th/uiform/login.aspx";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
					
				case "เข้าหน้าระบบ":
                    $textReplyMessage = "https://tbcmthailand.ddc.moph.go.th/uiform/login.aspx";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "log in":
                    $textReplyMessage = "https://tbcmthailand.ddc.moph.go.th/uiform/login.aspx";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "user request":
                    $textReplyMessage = "https://tbcmthailand.ddc.moph.go.th/uiform/User_Request.aspx";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
					
				case "เอกสารวิธีใช้งาน":
                    $textReplyMessage = "https://tbcmthailand.ddc.moph.go.th/uiform/Manual.aspx";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "ผู้ดูแลระบบ":                    
					$textReplyMessage = 
					"
					1.คุณสุทธา วัติรางกูล  แก้ไขปัญหาโปรแกรม และ Database System โทร.095-9606343
					2.คุณเสด็จ เบ้าทุมมา  แก้ไขปัญหาโปรแกรม และ Database System โทร.099-1858884
					3.คุณวิศรุต วัยวัฒนะ  แก้ไขปัญหาโปรแกรม และ Database System โทร.090-8142260
					";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "สปสช":                    
					$textReplyMessage = 
					"
					1	IT HELPDESK	สปสช	ตอบปัญหาการชดเชยสิทธิ์ สปสช (TB Data Hub)	1330 กด 5 กด 3	
					2	คุณจิโรจน์ นาคไพจิตร	สปสช	ดูแลการชดเชยสิทธิ์ สปสช		chirod_n@nhso.go.th					
					";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "เขต":                    
					$textReplyMessage = 
					"					
					1	คุณสินสมุทร จันทร์ทอง	โรงพยาบาลสันกำแพง จ.เชียงใหม่	ให้คำปรึกษาการใช้งานโปรแกรมเขต 1	081-9513771	jsinsamoot@hotmail.com
					2	คุณอัชฌ์พร เหล่าเจริญ	สำนักงานป้องกันควบคุมโรคที่ 2 จังหวัดพิษณุโลก	ให้คำปรึกษาการใช้งานโปรแกรมเขต 2	092-0365339	achaporn.lcr@gmail.com
					3	คุณพันธวัตร นุ่มเหลือ	สำนักงานป้องกันควบคุมโรคที่ 3 จังหวัดนครสวรรค์	ให้คำปรึกษาการใช้งานโปรแกรมเขต 3	087-3114175	pantawat_s@hotmail.com
					4	คุณดารณี ภักดิ์วาปี	สำนักงานป้องกันควบคุมโรคที่ 4 จังหวัดสระบุรี	ให้คำปรึกษาการใช้งานโปรแกรมเขต 4	081-9474626	ja_ao13@hotmail.com
					5	คุณศรัณย์ทัศน์ รอดพันธุ์	สำนักงานป้องกันควบคุมโรคที่ 5 จังหวัดราชบุรี	ให้คำปรึกษาการใช้งานโปรแกรมเขต 5	086-3566404	sek_rp@hotmail.com
					6	คุณณัฐธิสา บุญเจริญ	สำนักงานป้องกันควบคุมโรคที่ 6 จังหวัดชลบุรี	ให้คำปรึกษาการใช้งานโปรแกรมเขต 6	089-2887439	kam2_chuenjai@hotmail.com
					7	คุณสุดใจ หอธรรมกุล	ข้าราชการเกษียณ	ให้คำปรึกษาการใช้งานโปรแกรมเขต 7 และ 8	086-2244156	sjmin2500@yahoo.com
					8	คุณพิทักษ์ รักงาม	สำนักงานป้องกันควบคุมโรคที่ 9 นครราชสีมา	ให้คำปรึกษาการใช้งานโปรแกรมเขต 9	084-5507042	p_rakngam27@hotmail.com
					9	คุณทวีศักดิ์ สมควร	โรงพยาบาลห้วยทับทัน จังหวัดศรีสะเกษ	ให้คำปรึกษาการใช้งานโปรแกรมเขต 10	087-2592130	Groorakjing28@gmail.com
					10	คุณวิเชียร ตระกูลกลกิจ	โรงพยาบาลท่าศาลา จังหวัดนครศรีธรรมราช	ให้คำปรึกษาการใช้งานโปรแกรมเขต 11	084-0675144	wichian59@hotmail.com
					11	คุณสุรตัน อารง	สำนักงานสาธารณสุขจังหวัดปัตตานี	ให้คำปรึกษาการใช้งานโปรแกรมเขต 12	084-9968587	tan_raya@hotmail.com
					12	คุณณรงค์ศักดิ์ สิรินพมณี	สถาบันป้องกันควบคุมโรคเขตเมือง	ให้คำปรึกษาการใช้งานโปรแกรมเขต สปคม	089-9147070	sirinopmanee@hotmail.com
					";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
                case "t":

                    $textReplyMessage = "Bot ตอบคุณด้วยข้อความ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
				case "jo":

                    $textReplyMessage = "my name jo";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
				
                case "i":
                    $picFullSize = 'https://www.mywebsite.com/imgsrc/photos/f/simpleflower';
                    $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/simpleflower/240';
                    $replyData = new ImageMessageBuilder($picFullSize,$picThumbnail);
                    break;
                case "v":
                    $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/240';
                    $videoUrl = "https://www.mywebsite.com/simplevideo.mp4";
                    $replyData = new VideoMessageBuilder($videoUrl,$picThumbnail);
                    break;
                case "a":
                    $audioUrl = "https://www.mywebsite.com/simpleaudio.mp3";
                    $replyData = new AudioMessageBuilder($audioUrl,27000);
                    break;
                case "l":
                    $placeName = "ที่ตั้งร้าน";
                    $placeAddress = "แขวง พลับพลา เขต วังทองหลาง กรุงเทพมหานคร ประเทศไทย";
                    $latitude = 13.780401863217657;
                    $longitude = 100.61141967773438;
                    $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);
                    break;
                
				case "j":
                    $stickerID = 22;
                    $packageID = 2;
                    $replyData = new StickerMessageBuilder($packageID,$stickerID);
                    break;
                case "im":
                    $imageMapUrl = 'https://www.mywebsite.com/imgsrc/photos/w/sampleimagemap';
                    $replyData = new ImagemapMessageBuilder(
                        $imageMapUrl,
                        'This is Title',
                        new BaseSizeBuilder(699,1040),
                        array(
                            new ImagemapMessageActionBuilder(
                                'test image map',
                                new AreaBuilder(0,0,520,699)
                                ),
                            new ImagemapUriActionBuilder(
                                'http://www.ninenik.com',
                                new AreaBuilder(520,0,520,699)
                                )
                        ));
                    break;
                case "tm":
                    $replyData = new TemplateMessageBuilder('Confirm Template',
                        new ConfirmTemplateBuilder(
                                'Confirm template builder',
                                array(
                                    new MessageTemplateActionBuilder(
                                        'Yes',
                                        'Text Yes'
                                    ),
                                    new MessageTemplateActionBuilder(
                                        'No',
                                        'Text NO'
                                    )
                                )
                        )
                    );
                    break;
                    case "สถานการณ์โรค":
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder1 = array(
                          // new PostbackTemplateActionBuilder(
                          //     'สถาณการณ์โรค', // ข้อความแสดงในปุ่ม
                          //     http_build_query(array(
                          //         'disease_code'=>'26,27,66',
                          //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                          //     'สถานการณ์-โรคไข้เลือดออก'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                          // ),
                          new UriTemplateActionBuilder(
                                'สถานการณ์โรค', // ข้อความแสดงในปุ่ม
                                'https://flu.ddc.moph.go.th/bot/chart.php?disease_code=26-27-66'
                            ),
                          new UriTemplateActionBuilder(
                                'อาการของโรค', // ข้อความแสดงในปุ่ม
                                'https://ddc.moph.go.th/th/site/disease/detail/44/symptom'
                            ),
                        );
                        $actionBuilder2 = array(
                              // new PostbackTemplateActionBuilder(
                              //     'สถาณการณ์โรค', // ข้อความแสดงในปุ่ม
                              //     http_build_query(array(
                              //         'disease_code'=>'11',
                              //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                              //     'สถานการณ์-โรคมือเท้าปาก'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                              // ),
                              new UriTemplateActionBuilder(
                                    'สถานการณ์โรค', // ข้อความแสดงในปุ่ม
                                    'https://flu.ddc.moph.go.th/bot/chart.php?disease_code=71'
                                ),
                              new UriTemplateActionBuilder(
                                    'อาการของโรค', // ข้อความแสดงในปุ่ม
                                    'https://ddc.moph.go.th/th/site/disease/detail/11/symptom'
                                ),
                        );
                        $actionBuilder3 = array(
                                  // new PostbackTemplateActionBuilder(
                                  //     'สถาณการณ์โรค', // ข้อความแสดงในปุ่ม
                                  //     http_build_query(array(
                                  //         'disease_code'=>'13',
                                  //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                                  //     'สถานการณ์โรค'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                                  // ),
                                  new UriTemplateActionBuilder(
                                        'สถานการณ์โรค', // ข้อความแสดงในปุ่ม
                                        'https://flu.ddc.moph.go.th/bot/chart.php?disease_code=15'
                                    ),
                                  new UriTemplateActionBuilder(
                                        'อาการของโรค', // ข้อความแสดงในปุ่ม
                                        'https://ddc.moph.go.th/th/site/disease/detail/13/symptom'
                                    ),
                        );
                        $replyData = new TemplateMessageBuilder('Carousel',
                            new CarouselTemplateBuilder(
                                array(
                                    new CarouselColumnTemplateBuilder(
                                        'โรคไข้เลือดออก',
                                        'รายละเอียด-โรคไข้เลือดออก',
                                        'https://flu.ddc.moph.go.th/image-line/dhf_c.jpg',
                                        $actionBuilder1
                                    ),
                                    new CarouselColumnTemplateBuilder(
                                        'โรคมือเท้าปาก',
                                        'รายละเอียด-โรคมือเท้าปาก',
                                        'https://flu.ddc.moph.go.th/image-line/hfm_c.jpg',
                                        $actionBuilder2
                                    ),
                                    new CarouselColumnTemplateBuilder(
                                        'โรคไข้หวัดใหญ่',
                                        'รายละเอียด-โรคไข้หวัดใหญ่',
                                        'https://flu.ddc.moph.go.th/image-line/flu_c.jpg',
                                        $actionBuilder3
                                    ),
                                )
                            )
                        );
                    break;
                default:
                    $textReplyMessage = " คุณไม่ได้พิมพ์ ค่า ตามที่กำหนด";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
            }
            break;
        default:
            $textReplyMessage = json_encode($events);
            $replyData = new TextMessageBuilder($textReplyMessage);
            break;
    }
}
//l ส่วนของคำสั่งตอบกลับข้อความ
if(isset($replyToken) && $replyData){
  $response = $bot->replyMessage($replyToken,$replyData);
}

echo "OK";
