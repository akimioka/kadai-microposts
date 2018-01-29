<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }//

        public function favoriteds()
    {
        return $this->belongsToMany(Micropost::class, 'user_favorite','favorite_content', 'user_id')->withTimestamps();
    }
    public function unfavorite($id)
{
    // 既にお気に入りしているかの確認
    $exist = $this->is_favoriting($id);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist && !$its_me) {
        // 既にお気に入りしていればお気に入りを外す
        $this->favorite()->detach($id);
        return true;
    } else {
        // 未お気に入りであれば何もしない
        return false;
    }
}
    public function favorite($micropostId) { // 既にお気に入りしているかの確認 

$exist = $this->is_favoriting($micropostId);

    if ($exist || $its_me) {

        // 既にお気に入りしていれば何もしない

        return false;

    } else {

        // 未お気に入りであればお気に入りする

        $this->favoritings()->attach($micropostId);

        return true;

    }
}

public function is_favoriting($micropostId) {
    return $this->favoritings()->where('favorite_content', $micropostId)->exists();
}
}
