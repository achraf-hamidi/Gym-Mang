<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Auth;

class User extends Authenticatable {
	use Notifiable, HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'tele', 'cin', 'gender', 'image', 'is_valide', 'id_user',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $appends = ['user_permissions', 'model_role', 'list_permissions'];

	public function getUserPermissionsAttribute() {
		$permissions = [];
		foreach (Permission::all() as $permission) {
			if ($this->can($permission->name)) {
				$permissions[] = $permission->name;
			}
		}
		return $permissions;
	}

	public function getModelRoleAttribute() {
		return $this->hasRole('admin');
	}

	public function getListPermissionsAttribute() {
		/*$permissions = [];
			        foreach (Permission::all() as $permission) {
			          //if ($this->can($permission->name)) {
			            $permissions[] = $permission->name;
			          //}
		*/
		return Permission::all();
	}

	public function getParentAttribute() {
		$parent = User::where('id_user', $this->id_user)->first();
		return $parent;
	}

	public function parent() {
		return $this->belongsTo('App\User', 'id_user');
	}

	public function children() {
		return $this->hasMany('App\User', 'id_user');
	}

	public function messages() {
		return $this->belongsToMany('App\Message')->withPivot('id', 'user_id', 'to_user_id', 'seen_it');
	}
 


	/**
	 * Get all user permissions in a flat array.
	 *
	 * @return array
	 */
	public function getCanAttribute() {
		/*$permissions = [];
			        foreach (Permission::all() as $permission) {
			            if (Auth::user()->can($permission->name)) {
			                $permissions[$permission->name] = true;
			            } else {
			                $permissions[$permission->name] = false;
			            }
			        }
		*/
	}

}
