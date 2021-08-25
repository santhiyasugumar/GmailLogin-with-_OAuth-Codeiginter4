<?php
namespace App\Models;
use CodeIgniter\Model;

class Login_model extends Model
{
	protected $table='user';
	protected $primaryKey = 'id';
	protected $DBGroup='default';
	protected $allowedFields = ['oauth_id', 'name', 'email', 'profile_img', 'updated_at', 'created_at'];
}