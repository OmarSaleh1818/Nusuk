<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Opportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialController extends Controller
{

    public function OrganizationFinancial()
    {
        $user_id = Auth::user()->id;
        $financial = Financial::where('user_id', $user_id)->first();
        $opportunities = Opportunity::all();
        return view('organization.financial', compact('financial', 'opportunities'));
    }

    public function FinancialStore(Request $request)
    {
        $user_id = Auth::user()->id;

        Financial::updateOrCreate(
            ['user_id' => $user_id],
            [
                'public_sector' => $request->public_sector,
                'personalization_assignment' => $request->personalization_assignment,
                'services_sector' => $request->services_sector,
                'nonprofit_sector' => $request->nonprofit_sector,
                'commercial_monetary' => $request->commercial_monetary,
                'others_sector' => $request->others_sector,
                'private_sector' => $request->private_sector,
                'social' => $request->social,
                'general_expenses' => $request->general_expenses,
                'donations' => $request->donations,
                'endowment_wallet' => $request->endowment_wallet,
                'marketing_expenses' => $request->marketing_expenses,
                'self_employment' => $request->self_employment,
                'loans_received' => $request->loans_received,
                'directed_expenses' => $request->directed_expenses,
                'borrowing_paying' => $request->borrowing_paying,
                'suspense_polarization' => $request->suspense_polarization,
                'special_needs' => $request->special_needs,
                'public_places' => $request->public_places,
                'translation' => $request->translation,
                'awareness_education' => $request->awareness_education,
                'attracting_volunteers' => $request->attracting_volunteers,
                'project_development' => $request->project_development,
                'smart_applications' => $request->smart_applications,
                'reception' => $request->reception,
                'health_care' => $request->health_care,
                'village_development' => $request->village_development,
                'interaction_facilities' => $request->interaction_facilities,
                'farewell_distribution' => $request->farewell_distribution,
                'security_safety' => $request->security_safety,
                'media_contribution' => $request->media_contribution,
                'leadership_innovation' => $request->leadership_innovation,
                'transport' => $request->transport,
                'cash_assistance' => $request->cash_assistance,
                'advocacy_guidance' => $request->advocacy_guidance,
                'studies_research' => $request->studies_research,
                'reservations_facilities' => $request->reservations_facilities,
                'eye_assistance' => $request->eye_assistance,
                'child_care' => $request->child_care,
                'qualification_training' => $request->qualification_training,
                'basic_services' => $request->basic_services,
                'feeding_watering' => $request->feeding_watering,
                'seasonal_services' => $request->seasonal_services,
                'establishing_initiatives' => $request->establishing_initiatives,
                'organizing_events' => $request->organizing_events,
                'ministry_hajj' => $request->ministry_hajj,
                'ministry_municipal_affairs' => $request->ministry_municipal_affairs,
                'ministry_transportation' => $request->ministry_transportation,
                'ministry_hr' => $request->ministry_hr,
                'ministry_tourism' => $request->ministry_tourism,
                'Development_authority' => $request->Development_authority,
                'ministry_interior' => $request->ministry_interior,
                'ministry_media' => $request->ministry_media,
                'general_presidency' => $request->general_presidency,
                'ministry_external' => $request->ministry_external,
                'ministry_health' => $request->ministry_health,
                'royal_commission' => $request->royal_commission,
                'fixed_assets' => $request->fixed_assets,
                'investment_wallet' => $request->investment_wallet,
                'book_endowment_wallet' => $request->book_endowment_wallet,
                'association_fund' => $request->association_fund,
                'stocks_securities' => $request->stocks_securities,
                'other_investments' => $request->other_investments,
                'social_investments' => $request->social_investments,
                'investment_portfolio_management' => $request->investment_portfolio_management,
                'paid_CEO' => $request->paid_CEO,
                'paid_employee' => $request->paid_employee,
                'created_at' => Carbon::now(),
            ]
        );

        return redirect()->route('organization.financial')->with('error', 'تم حفظ المعلومات بنجاح');
    }



}
