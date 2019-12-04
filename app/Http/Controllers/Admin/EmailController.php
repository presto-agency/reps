<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailSendRequest;
use App\Notifications\CustomEmail;
use App\User;

class EmailController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emailCreate($id)
    {

        $user = User::select('email')->findOrFail($id);

        $content = view('admin.send-email.create', compact('user'));

        return \AdminSection::view($content, 'Отправка Email');
    }

    /**
     * @param \App\Http\Requests\EmailSendRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function emailSend(EmailSendRequest $request)
    {

        $user = new User();
        $user->email = $request->to_email;
        try {
            $user->notify(new CustomEmail($request->subject, $request->message));
            $request->session()->flash('email-send', 'Вы отправили письмо к ' . $request->to_email);
        } catch (\Exception $e) {
            $request->session()->flash('email-send', 'Ошибка при отправки письма к ' . $request->to_email);
            \Log::error($e);
        }

        return back();
    }

}
