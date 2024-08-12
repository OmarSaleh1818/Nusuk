<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('public_sector');
            $table->integer('personalization_assignment');
            $table->integer('services_sector');
            $table->integer('nonprofit_sector');
            $table->integer('commercial_monetary');
            $table->integer('others_sector');
            $table->integer('private_sector');
            $table->integer('social');
            $table->integer('general_expenses');
            $table->integer('donations');
            $table->integer('endowment_wallet');
            $table->integer('marketing_expenses');
            $table->integer('self_employment');
            $table->integer('loans_received');
            $table->integer('directed_expenses');
            $table->integer('borrowing_paying');
            $table->integer('suspense_polarization');
            $table->integer('special_needs');
            $table->integer('public_places');
            $table->integer('translation');
            $table->integer('awareness_education');
            $table->integer('attracting_volunteers');
            $table->integer('project_development');
            $table->integer('smart_applications');
            $table->integer('reception');
            $table->integer('health_care');
            $table->integer('village_development');
            $table->integer('interaction_facilities');
            $table->integer('farewell_distribution');
            $table->integer('security_safety');
            $table->integer('media_contribution');
            $table->integer('leadership_innovation');
            $table->integer('transport');
            $table->integer('cash_assistance');
            $table->integer('advocacy_guidance');
            $table->integer('studies_research');
            $table->integer('reservations_facilities');
            $table->integer('eye_assistance');
            $table->integer('child_care');
            $table->integer('qualification_training');
            $table->integer('basic_services');
            $table->integer('feeding_watering');
            $table->integer('seasonal_services');
            $table->integer('establishing_initiatives');
            $table->integer('organizing_events');
            $table->integer('ministry_hajj');
            $table->integer('ministry_municipal_affairs');
            $table->integer('ministry_transportation');
            $table->integer('ministry_hr');
            $table->integer('ministry_tourism');
            $table->integer('Development_authority');
            $table->integer('ministry_interior');
            $table->integer('ministry_media');
            $table->integer('general_presidency');
            $table->integer('ministry_external');
            $table->integer('ministry_health');
            $table->integer('royal_commission');
            $table->integer('fixed_assets');
            $table->integer('investment_wallet');
            $table->integer('book_endowment_wallet');
            $table->integer('association_fund');
            $table->integer('stocks_securities');
            $table->integer('other_investments');
            $table->integer('social_investments');
            $table->integer('investment_portfolio_management');
            $table->integer('paid_CEO');
            $table->integer('paid_employee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};
