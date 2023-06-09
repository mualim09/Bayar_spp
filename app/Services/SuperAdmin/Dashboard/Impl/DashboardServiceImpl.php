<?php

namespace App\Services\SuperAdmin\Dashboard\Impl;

use App\Models\School\School;
use App\Models\School\SchoolType;
use App\Models\User\Admin;
use App\Services\SuperAdmin\Dashboard\DashboardService;

class DashboardServiceImpl implements DashboardService
{
    private $schoolModel, $schoolTypeModel, $adminModel;

    public function __construct(School $schoolModel, SchoolType $schoolTypeModel, Admin $adminModel)
    {
        $this->schoolModel = $schoolModel;
        $this->schoolTypeModel = $schoolTypeModel;
        $this->adminModel = $adminModel;
    }

    /**
     * Get Amount SMA Schools
     *
     * @return mixed
     */
    public function getAmountSMASchools(): mixed
    {
        $schoolTypeSMAId = $this->schoolTypeModel->where(
            function ($q) {
                $q->where('name', 'SMA');
            }
        )->first()->id;

        $schools = $this->schoolModel->where(
            function ($q) use ($schoolTypeSMAId) {
                $q->where('school_type_id', $schoolTypeSMAId);
            }
        )->count();

        return $schools;
    }

    /**
     * Get Amount SMK Schools
     *
     * @return mixed
     */
    public function getAmountSMKSchools(): mixed
    {
        $schoolTypeSMKId = $this->schoolTypeModel->where(
            function ($q) {
                $q->where('name', 'SMK');
            }
        )->first()->id;

        $schools = $this->schoolModel->where(
            function ($q) use ($schoolTypeSMKId) {
                $q->where('school_type_id', $schoolTypeSMKId);
            }
        )->count();

        return $schools;
    }

    /**
     * Get Amount Admins
     *
     * @return int
     */
    public function getAmountAdmins(): int
    {
        return $this->adminModel->query()->count();
    }
}
