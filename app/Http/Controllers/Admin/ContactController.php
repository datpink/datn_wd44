<?php

namespace App\Http\Controllers\Admin;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Models\Contact; // Sử dụng model Contact
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $title = 'Danh Sách Liên Hệ';
        // Lấy danh sách liên hệ từ cơ sở dữ liệu
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(7);
        return view('admin.contact.index', compact('contacts', 'title')); // Truyền biến contacts đến view
    }

    public function destroy($id)
    {
        // Xóa liên hệ theo ID
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Liên hệ đã được xóa thành công!');
    }

    public function reply(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'reply' => 'required|string',
        ]);

        // Tìm liên hệ và cập nhật trường reply
        $contact = Contact::findOrFail($id);
        $contact->reply = $request->reply;
        $contact->save();

        // Gửi email trả lời
        Mail::to($contact->email)->send(new ContactReplyMail($contact, $request->reply));

        return redirect()->route('admin.contact.index')->with('success', 'Trả lời đã được gửi thành công!');
    }
}