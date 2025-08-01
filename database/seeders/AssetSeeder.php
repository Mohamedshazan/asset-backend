<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run()
    {
        $assets = [
            [
                "department_id" => 5,
                "brand" => "Dell",
                "model" => "OptiPlex 710",
                "device_name" => "dell-optipex7010-5021",
                "os" => "Windows 11 Pro",
                "serial_number" => "DELL710SN5021",
                "status" => "backup",
                "asset_type" => "Desktop",
                "location" => "1st Floor - Admin Office"
            ],
            [
                "department_id" => 3,
                "brand" => "HP",
                "model" => "LaserJet Pro M404n",
                "device_name" => "hp-m404n-3011",
                "os" => "N/A",
                "serial_number" => "HP404SN3011",
                "status" => "live",
                "asset_type" => "Printer",
                "location" => "2nd Floor - Accounts Dept"
            ],
            [
                "department_id" => 2,
                "brand" => "Canon",
                "model" => "imageCLASS LBP6230dw",
                "device_name" => "canon-6230dw-4021",
                "os" => "N/A",
                "serial_number" => "CN6230SN4021",
                "status" => "to_be_disposal",
                "asset_type" => "Printer",
                "location" => "Ground Floor - Reception"
            ],
            [
                "department_id" => 4,
                "brand" => "HP",
                "model" => "EliteDesk 800 G6",
                "device_name" => "hp-elitedesk800g6-6011",
                "os" => "Windows 10 Pro",
                "serial_number" => "HPE800SN6011",
                "status" => "live",
                "asset_type" => "Desktop",
                "location" => "3rd Floor - HR Office"
            ],
            [
                "department_id" => 6,
                "brand" => "Epson",
                "model" => "EcoTank L3250",
                "device_name" => "epson-l3250-7081",
                "os" => "N/A",
                "serial_number" => "EPSL3250SN7081",
                "status" => "backup",
                "asset_type" => "Printer",
                "location" => "1st Floor - Library"
            ],
            [
                "department_id" => 2,
                "brand" => "Dell",
                "model" => "Latitude 5520",
                "device_name" => "dell-lat5520-4312",
                "os" => "Windows 11 Pro",
                "serial_number" => "DELLLAT5520SN4312",
                "status" => "live",
                "asset_type" => "Laptop",
                "location" => "Finance Department"
            ],
            [
                "department_id" => 4,
                "brand" => "HP",
                "model" => "ProDesk 400 G7",
                "device_name" => "hp-prodesk400g7-6210",
                "os" => "Windows 10 Pro",
                "serial_number" => "HPPD400G7SN6210",
                "status" => "live",
                "asset_type" => "Desktop",
                "location" => "Operations Floor"
            ],
            [
                "department_id" => 3,
                "brand" => "Brother",
                "model" => "DCP-L2540DW",
                "device_name" => "brother-dcp2540-3098",
                "os" => "N/A",
                "serial_number" => "BRDCP2540SN3098",
                "status" => "live",
                "asset_type" => "Printer",
                "location" => "Accounts Room"
            ],
            [
                "department_id" => 1,
                "brand" => "Lenovo",
                "model" => "ThinkPad T14",
                "device_name" => "lenovo-t14-1001",
                "os" => "Windows 11",
                "serial_number" => "LENT14SN1001",
                "status" => "live",
                "asset_type" => "Laptop",
                "location" => "IT Department"
            ],
            [
                "department_id" => 6,
                "brand" => "Canon",
                "model" => "PIXMA G3020",
                "device_name" => "canon-pixma3020-7092",
                "os" => "N/A",
                "serial_number" => "CNPXG3020SN7092",
                "status" => "live",
                "asset_type" => "Printer",
                "location" => "Library"
            ],
            [
                "department_id" => 5,
                "brand" => "Acer",
                "model" => "Veriton X4660G",
                "device_name" => "acer-veriton4660g-5022",
                "os" => "Windows 10 Pro",
                "serial_number" => "ACERX4660GSN5022",
                "status" => "live",
                "asset_type" => "Desktop",
                "location" => "Admin Office"
            ],
            [
                "department_id" => 4,
                "brand" => "HP",
                "model" => "LaserJet MFP M236sdw",
                "device_name" => "hp-m236sdw-6233",
                "os" => "N/A",
                "serial_number" => "HPM236SDWSN6233",
                "status" => "live",
                "asset_type" => "Printer",
                "location" => "Operations Department"
            ],
            [
                "department_id" => 2,
                "brand" => "Apple",
                "model" => "MacBook Pro M1",
                "device_name" => "apple-mbp-m1-4221",
                "os" => "macOS Ventura",
                "serial_number" => "MBPM1SN4221",
                "status" => "live",
                "asset_type" => "Laptop",
                "location" => "Finance - Head Office"
            ],
            [
                "department_id" => 3,
                "brand" => "Ricoh",
                "model" => "IM C2000",
                "device_name" => "ricoh-imc2000-3081",
                "os" => "N/A",
                "serial_number" => "RICIMC2000SN3081",
                "status" => "to_be_disposal",
                "asset_type" => "Printer",
                "location" => "2nd Floor - Admin"
            ],
            [
                "department_id" => 1,
                "brand" => "Asus",
                "model" => "ExpertBook B1",
                "device_name" => "asus-b1-1111",
                "os" => "Windows 11 Pro",
                "serial_number" => "ASUSB1SN1111",
                "status" => "backup",
                "asset_type" => "Laptop",
                "location" => "IT Spare Devices"
            ]
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}
