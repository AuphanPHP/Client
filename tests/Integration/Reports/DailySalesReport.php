<?php

namespace AuphanPHP\Tests\Integration\Reports;

use AuphanPHP\Reports\ReportInterface;

class DailySalesReport implements ReportInterface
{
    public function getReportEndpoint(): string
    {
        return 'reports/api.php';
    }

    public function getReportParameters(): array
    {
        return [
            'report' => 'Hub Daily Sales',
            'export' => 'json',
            'variables' => [
                'store_groups' => [
                    0 => [
                        'value' => 'g1021',
                        'name' => 'Canada Stores',
                    ],
                    1 => [
                        'value' => 'g1028',
                        'name' => 'United States',
                    ],
                ],
                'separate_stores' => 0,
                'selection' => 'close_date',
                'use_time' => 1,
                'date_from' => '2022-01-01 00:00:00',
                'date_to' => '2022-01-03 23:30:00',
                'dow' => '',
                'employee_id' => '',
                'cashier_id' => '',
                'enter_employee_id' => '',
                'delete_employee_id' => '',
                'commission_id' => '',
                'open_station_id' => '',
                'close_station_id' => '',
                'shift_id' => '',
                'status' => [
                    0 => '1',
                ],
                'invoice_status' => [
                    0 => '2',
                ],
                'kitchen' => '',
                'item_type' => [
                    0 => '1',
                ],
                'product_sku' => '',
                'invoice_id' => '',
                'table_type_id' => '',
                'web_order' => '',
                'kiosk_order' => '',
                'web_type' => '',
                'kiosk_type' => '',
                'cc_invoices_only' => 0,
                'customer_id' => [
                ],
                'customer_group_id' => '',
                'product_id' => [
                ],
                'category_id' => [
                ],
                'parent_category_id' => [
                ],
                'report_cat_id' => '',
                'payment_type_id' => '',
                'print_num' => '',
                'invoice_print_num' => '',
                'coupon_codes' => '',
                'coupon_code_set' => '1',
                'only_discounted_sales' => 0,
                'only_invoice_discounted_sales' => 0,
                'only_saleruled_sales' => 0,
                'only_price_reduced_sales' => 0,
                'only_discount_approved_items' => 0,
                'only_discount_approved_invoices' => 0,
                'only_discount_approved_items_invoices' => 0,
                'only_tax_exempted_sales' => 0,
                'only_recovered_items' => 0,
                'hide_recovered_items' => 0,
                'weather_type' => '',
                'precip_type' => '',
                'max_temp' => '',
                'min_temp' => '',
                'sales_percent_grouped' => 0,
                'page_break' => 0,
                'collapse_groups' => 0,
                'hide_empty_rows' => 1,
                'group_totals' => 0,
                'grand_totals' => 0,
                'font_size' => '12',
                'page_width' => '100%',
                'report_datetime_format' => '',
                'report_date_format' => '',
                'report_time_format' => '',
                'report_format_money' => 1,
                'pivot_expand' => '1',
            ],
        ];
    }
}