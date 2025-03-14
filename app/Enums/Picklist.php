<?php

namespace App\Enums;

class Picklist {
    private static $enum = [
        'product' => [
            'product_category' => [
                'my_pham' => 'Mỹ phẩm',
                'thoi_trang' => 'Thời trang',
            ],
        ],
        'service' => [
            'service_category' => [
                'my_pham' => 'Mỹ phẩm',
                'thoi_trang' => 'Thời trang',
            ],
        ],
        'user' => [
            'role' => [
                'admin' => 'Admin',
                'manager' => 'Quản lý',
                'normal_user' => 'Nguời dùng thường',
            ],
        ],
        'product_stock' => [
            'stock_type' => [
                'import' => 'Nhập kho',
                'export' => 'Xuất kho',
            ],
            'description' => [
                'User_generated_content' => 'Người dùng tự tạo',
                'Export_order' => 'Xuất đơn hàng',
            ],
        ],
        'salesorder' => [
            'status' => [
                'confirmed' => 'Đã xác nhận',
                'approved' => 'Đã duyệt',
                'completed' => 'Hoàn thành',
                'refund' => 'Chuyển hoàn',
            ],
            'payment_method' => [
                'chuyen_khoan' => 'Chuyển khoản',
                'approved' => 'Tiền mặt',
            ],
            'payment_status' => [
                'Unpaid' => 'Chưa thanh toán',
                'Partially Paid' => 'Đã thanh toán một phần',
                'Paid' => 'Đã thanh toán',
            ],
        ],
        'employee' => [
            'role' => [
                'sales' => 'Nhân viên sales',
                'developer' => 'Nhân viên dev',
                'maketing' => 'Nhân viên marketing',
                'support' => 'Nhân viên hỗ trợ',
                'business' => 'Nhân viên kinh doanh',
                'business_analyst' => 'Nhân viên phân tích',
            ]
        ]
    ];

    public static function getPicklistView($module, $placeholder, $fieldKey, $selectedValue = '', $isDisabled = false) {
        $picklist = self::$enum[$module][$fieldKey];

        return view('components.picklist', [
            'picklist' => $picklist,
            'placeholder' => $placeholder,
            'fieldname' => $fieldKey,
            'checkedValue' => $selectedValue,
            'isDisabled' => $isDisabled,
        ]);
    }

    public static function getPicklistValue($module, $fieldKey, $picklistKey) {
        $picklistValue = self::$enum[$module][$fieldKey][$picklistKey];
        return $picklistValue;
    }
}