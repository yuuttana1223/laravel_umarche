<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Throwable;

class OwnersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $owners = Owner::select('id', 'name', 'email', 'created_at')->paginate(3);
        return view('admin.owners.index', compact('owners'));
    }

    public function create()
    {
        return view('admin.owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        try {
            // useに使う変数を記述
            DB::transaction(function () use ($request) {
                $owner = Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                Shop::create([
                    'owner_id' => $owner->id,
                    'name' => '店名',
                    'information' => '',
                    'filename' => '',
                    'is_selling' => true,
                ]);
            });
        } catch (Throwable $e) {
            // ログ(storage/logs/laravel.log)に出力
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('admin.owners.index')
            ->with([
                'message' => 'オーナー登録を実施しました。',
                'status' => 'info'
            ]);
    }

    public function edit(Owner $owner)
    {
        return view('admin.owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);

        return redirect()
            ->route('admin.owners.index')
            ->with([
                'message' => 'オーナー情報を更新しました。',
                'status' => 'info'
            ]);
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()
            ->route('admin.owners.index')
            ->with([
                'message' => 'オーナー情報を削除しました。',
                'status' => 'alert'
            ]);
    }

    public function expiredOwnerIndex()
    {
        // onlyTrashed()でソフトデリートしたものだけを取れる
        $expiredOwners = Owner::onlyTrashed()->get();
        return view(
            'admin.owners.expired-owners',
            compact('expiredOwners')
        );
    }
    public function expiredOwnerDestroy($id)
    {
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()
            ->route('admin.expired-owners')
            ->with([
                'message' => 'オーナー情報を完全に削除しました。',
                'status' => 'alert'
            ]);
    }
}
