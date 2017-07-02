<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
    
    protected $user_id = null;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'passhash'];

    public function session(){
        $this->hasMany('Session');
    }

    public function config(){
        $this->hasMany('Config');
    }

    protected function createUser($name, $email, $password){
    	if (!filter_var(htmlentities(trim($email)), FILTER_VALIDATE_EMAIL)) {
            throw new Exception(350);
        }

        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		  	throw new Exception(393);
		}

        $password = Repo::hash($password);

        if (User::where('email', $email)->count() == 1){
                throw new Exception(394);
        } else {
            if (User::create([
                    'name'      => $name,
                    'email'		=> $email,
                    'passhash'	=> $password,
            ])){
                return true;
            } else {
                throw new Exception(3350);
            }
        }
                
    }

    public function avatarUrl(array $options = []){
        $size = array_get($options, 'size', 200);
        $id = array_get($options, 'id', Session::getUser()->id);
        $option = array_get($options, 'option', '');
        if (!$this->uuid){
            return 'https://www.gravatar.com/avatar/'.md5(strtolower(self::getUser($id)['email'])).'?d=mm&size='.$size;
        }
        return 'https://ucarecdn.com/' . $options['uuid'] . '/-/scale_crop/1024x1024/center/-/quality/best/-/progressive/yes/-/resize/' . $size . '/'.$option;
    }

    public function getUser($id){
        return User::where('id', $id)->first();
    }

}

?>
