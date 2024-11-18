<?php

namespace App\Http\Controllers\Admin;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Models\Contact; // Sử dụng model Contact
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Liên Hệ';
        $query = Contact::query();

        // Tìm kiếm theo tên hoặc email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Lọc theo ngày
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Lọc theo trạng thái trả lời
        if ($request->has('reply') && $request->reply !== '') {
            if ($request->reply === '1') {
                $query->whereNotNull('reply');
            } elseif ($request->reply === '0') {
                $query->whereNull('reply');
            }
        }

        // Lấy danh sách liên hệ, sắp xếp theo ngày và phân trang
        $contacts = $query->orderBy('created_at', 'desc')->paginate(7);

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