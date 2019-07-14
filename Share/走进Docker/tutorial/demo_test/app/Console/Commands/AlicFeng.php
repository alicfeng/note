<?php

namespace App\Console\Commands;

use AlicFeng\IdentityCard\IdentityCard;
use App\Model\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AlicFeng extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $frontImage = IdentityCard::createFrontImage('冯大叔', '男', '汉', 1560089097, '广东省阳江市海陵镇试验区某某村委会某某村888号', '441701199506028888');
        imagepng($frontImage, 'front.png');
        imagedestroy($frontImage);
//
//        $backImage = IdentityCard::createBackImage('2016.06.02', '2026.12.08');
//        imagepng($backImage, 'back.png');
//        imagedestroy($backImage);

        Log::info(json_encode(User::with(['userinfo'])->get(), JSON_UNESCAPED_UNICODE));

        Log::info(IdentityCard::province('441701199506020016'));
        Log::info(IdentityCard::city('441701199506020016'));
        Log::info(IdentityCard::area('441701199506020016', '海陵岛'));
    }
}
