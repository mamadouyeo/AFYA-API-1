<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Pharmacy
 * 
 * @property int $id
 * @property int $zone_supervisions_id
 * @property string|null $nom
 * @property string|null $contacts
 * @property string|null $Email
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property string|null $localisation
 * @property string|null $garde
 * @property string|null $longitude
 * @property string|null $latitude
 * @property string|null $id_users
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ZoneSupervision $zone_supervision
 * @property Collection|Facture[] $factures
 * @property Collection|OrdonnancesHasPharmacy[] $ordonnances_has_pharmacies
 *
 * @package App\Models
 */
class Pharmacy extends Model
{
    use HasApiTokens,HasFactory;
	protected $table = 'pharmacies';

	protected $casts = [
		'zone_supervisions_id' => 'int'
	];

	protected $fillable = [
		'zone_supervisions_id',
		'nom',
		'tel_pharmacie',
		'Email',
		'ville',
		'commune_quartier',
		'localisation',
		'garde',
		'longitude',
		'latitude',
		'id_users'
	];

	public function zone_supervision()
	{
		return $this->belongsTo(ZoneSupervision::class, 'zone_supervisions_id');
	}

	public function factures()
	{
		return $this->hasMany(Facture::class, 'pharmacies_id');
	}

	public function ordonnances_has_pharmacies()
	{
		return $this->hasMany(OrdonnancesHasPharmacy::class, 'pharmacies_id');
	}
}
