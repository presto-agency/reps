<?php

use App\Models\Footer;
use Illuminate\Database\Seeder;

class SeederFooter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Footer::query()->firstOrNew(['title' => 'Disclaimer']);
        if (!$data->exists) {
            $data->fill([
                'title' => 'Disclaimer',
                'text'  => 'text',
            ])->save();
        }
        $data = Footer::query()->firstOrNew(['title' => 'Disclaimer']);
        if ($data->exists) {
            $text = "<h2 class=\"info__title footer__title\">Disclaimer</h2>
<p class=\"footer__text\">Этот сайт предназначен для посетителей старше 21 года.</p>
<p class=\"info__title footer__title\">По всем вопросам обращайтесь:</p>
<p><img style=\"width:15px\" src=\"/images/icons/mail_icon.png\" alt=\"mail\" /> <a class=\"footer__mail\" href=\"mailto:treasury@reps.ru\">treasury@reps.ru</a></p>
<p><img src=\"/images/icons/discord-logo-vector.png\" alt=\"discord\" /> Rus_Brain#6290</p></code></pre>";
            $data->fill([
                'text' => $text,
            ])->save();
        }

    }
}
