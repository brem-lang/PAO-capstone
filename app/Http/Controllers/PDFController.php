<?php

namespace App\Http\Controllers;

use App\Models\IDType;
use App\Models\InterViewSheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePDF(InterViewSheet $interViewSheet)
    {
        return $this->notarize($interViewSheet);
    }

    public function notarize($interViewSheet)
    {

        $view = '';

        switch ($interViewSheet->aol_type) {
            case 'affidavit_loss':
                $view = 'AOL';
                break;

            case 'qr_code':
                $view = 'QRCode';
                break;

            case 'id':
                $view = 'ID';
                break;

            case 'id_philippine':
                $view = 'PhilippineID';
                break;

            case 'atm_passbook':
                $view = 'ATMPASSBOOK';
                break;

            case 'documents':
                $view = 'Document';
                break;

            case 'prof_nonprof_drivers_license':
                $view = 'License';
                break;

            case 'lost_items_documents':
                $view = 'LostItem';
                break;

            case 'new_type':
                $view = 'newAOL';
                break;
        }

        $date = Carbon::parse($interViewSheet->created_at); // Or any date, e.g., Carbon::parse('2024-11-23')

        $formattedDate = $date->format('jS').' day of '.$date->format('F Y');

        $pdf = \PDF::loadView('pdf.'.$view, [
            'age' => $interViewSheet->age,
            'civilStatus' => $interViewSheet->civilStatus,
            'stuDEmp' => $interViewSheet->stuDEmp,
            'documentTypeAOL' => $interViewSheet->documentTypeAOL,
            'issuedByAOL' => $interViewSheet->issuedByAOL,
            'newAOL_type' => $interViewSheet->newAOL_type ?? null,
            'statements' => $interViewSheet->statements ?? null,
            //
            'name' => $interViewSheet?->name,
            'idType' => $this->handleIDType($interViewSheet->id_type) ?? $interViewSheet->id_type,
            'id_number' => $interViewSheet->id_number,
            'formattedDate' => $formattedDate,
            'address' => $this->handleTypeBarangay($interViewSheet->barangay).', '.$this->handleTypeCity($interViewSheet->city).', '.$this->handleTypeProvince($interViewSheet->province),
        ])->setPaper('legal');

        return $pdf->stream(ucfirst($interViewSheet->aol_type).'-'.now()->format('Y-m-d h:i:s').'.pdf');
    }

    public function sheet(InterViewSheet $interViewSheet)
    {

        $pdf = \PDF::loadView('pdf.advice', $interViewSheet->toArray())->setPaper('legal');

        return $pdf->stream(now()->format('Y-m-d h:i:s').'.pdf');
    }

    public function handleIDType($idType)
    {
        $idTypes = [
            'passport' => 'Passport',
            'drivers_license' => 'Driver\'s License',
            'prc_license' => 'PRC License',
            'umid' => 'UMID',
            'postal_id' => 'Postal ID',
            'voters_id' => 'Voter\'s ID ',
            'philhealth' => 'PhilHealth',
            'pagibig' => 'Pag-IBIG ID',
            'barangay_cert' => 'Barangay Certification',
            'sss_id' => 'SSS ID',
            'senior_citizen' => 'Senior Citizen ID',
            'pwd_id' => 'PWD ID',
        ];

        if (array_key_exists($idType, $idTypes)) {
            return $idTypes[$idType];
        }

        return null;
    }

    public function handleTypeBarangay($code)
    {
        return DB::table('barangays')->where('id', $code)->first()->name;
    }

    public function handleTypeCity($code)
    {
        return DB::table('cities')->where('city_id', $code)->first()->name;
    }

    public function handleTypeProvince($code)
    {
        return DB::table('provinces')->where('province_id', $code)->first()->name;
    }

    public function generateID(User $user)
    {

        $pdf = \PDF::loadView('pdf.viewID', [
            'idType' => IDType::where('id', $user->documents->first()->id_type)->first()->name,
            'id_number' => $user->documents->first()->id_number,
            'front_id' => $user->documents->first()->front_id,
            'back_id' => $user->documents->first()->back_id,
        ])->setPaper('legal');

        return $pdf->stream(now()->format('Y-m-d h:i:s').'.pdf');
    }
}
