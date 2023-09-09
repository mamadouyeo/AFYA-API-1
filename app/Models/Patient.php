<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Patient
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $date_naissance
 * @property string $genre
 * @property string $telephone
 * @property string $Email
 * @property string $password
 * @property string $cni
 * @property string|null $profession
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property string|null $parrainage
 * @property string|null $id_users
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Facture[] $factures
 * @property Collection|Ordonnance[] $ordonnances
 *
 * @package App\Models
 */
class Patient extends Model
{

	// use HasApiTokens, HasFactory, Notifiable;

	protected $table = 'patients';

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'date_naissance',
		'genre',
		'telephone',
		'email',
		'password',
		'cni',
		'profession',
		'ville',
		'commune_quartier',
		'parrainage',
		'id_users'
	];

	public function factures()
	{
		return $this->hasMany(Facture::class, 'patients_id');
	}

	public function ordonnances()
	{
		return $this->hasMany(Ordonnance::class, 'patients_id');
	}
}
