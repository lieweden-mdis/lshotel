<?php
include 'config.php';

function getBookingDetails($conn, $booking_id) {
    $sql = "SELECT b.*, u.first_name, u.last_name, r.room_type, r.room_price 
            FROM bookings b 
            JOIN users u ON b.email = u.email 
            JOIN rooms r ON b.room_id = r.room_id 
            WHERE b.booking_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    if (!$booking) {
        throw new Exception('Booking not found.');
    }

    return $booking;
}

function insertOrUpdateInvoice($conn, $booking) {
    $sql = "INSERT INTO invoices (booking_id, amount, payment_status, email) 
            SELECT ?, ?, ?, ? 
            FROM DUAL 
            WHERE NOT EXISTS (SELECT 1 FROM invoices WHERE booking_id = ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("isssi", $booking['booking_id'], $booking['total_amount'], $booking['payment_status'], $booking['email'], $booking['booking_id']);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $sql = "SELECT id FROM invoices WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking['booking_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $invoice = $result->fetch_assoc();
        $invoice_db_id = $invoice['id'];
    } else {
        $invoice_db_id = $stmt->insert_id;
    }
    $stmt->close();

    return $invoice_db_id;
}

function updateInvoiceId($conn, $invoice_db_id) {
    $invoice_id = 'INV' . str_pad($invoice_db_id, 5, '0', STR_PAD_LEFT);
    $sql = "UPDATE invoices SET invoice_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("si", $invoice_id, $invoice_db_id);
    $stmt->execute();
    $stmt->close();

    return $invoice_id;
}

function calculateAdditionalCharges($additional_requests) {
    $extra_bed_charge = 10;
    $breakfast_charge = 35;
    $extra_bed_total = 0;
    $breakfast_total = 0;
    $extra_bed_qty = 0;
    $breakfast_qty = 0;

    foreach ($additional_requests as $request) {
        if (isset($request['extra_bed']) && $request['extra_bed'] === 'Yes') {
            $extra_bed_qty += $request['bed_quantity'];
            $extra_bed_total += $request['bed_quantity'] * $extra_bed_charge;
        }
        if (isset($request['add_breakfast']) && $request['add_breakfast'] === 'Yes') {
            $breakfast_qty += $request['breakfast_quantity'];
            $breakfast_total += $request['breakfast_quantity'] * $breakfast_charge;
        }
    }

    return [
        'extra_bed_total' => $extra_bed_total,
        'breakfast_total' => $breakfast_total,
        'extra_bed_qty' => $extra_bed_qty,
        'breakfast_qty' => $breakfast_qty,
    ];
}

try {
    if (!isset($_GET['booking_id'])) {
        throw new Exception('Booking ID is not set.');
    }
    $booking_id = $_GET['booking_id'];
    $booking = getBookingDetails($conn, $booking_id);
    $invoice_db_id = insertOrUpdateInvoice($conn, $booking);
    $invoice_id = updateInvoiceId($conn, $invoice_db_id);

    $additional_requests = json_decode($booking['additional_requests'], true);
    $charges = calculateAdditionalCharges($additional_requests);

    $room_total = $booking['room_price'] * $booking['number_of_rooms'] * $booking['days'];
    $total_amount = $room_total + $charges['extra_bed_total'] + $charges['breakfast_total'];

    $conn->close();
} catch (Exception $e) {
    die($e->getMessage());
}
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" href="css/invoice.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
</head>
<body>
    <div class="invoice-wrapper" id="print-area">
        <div class="invoice">
            <div class="invoice-container">
                <div class="invoice-head">
                    <div class="invoice-head-top">
                        <div class="invoice-head-top-left text-start">
                            <img src="img/logo.png" alt="Logo" id="logo">
                        </div>
                        <div class="invoice-head-top-right text-end">
                            <h3>Invoice</h3>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="invoice-head-middle">
                        <div class="invoice-head-middle-left text-start">
                            <p><span class="text-bold">Date</span>: <?php echo date('d/m/Y'); ?></p>
                        </div>
                        <div class="invoice-head-middle-right text-end">
                            <p><span class="text-bold">Invoice No:</span> <?php echo $invoice_id; ?></p>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="invoice-head-bottom">
                        <div class="invoice-head-bottom-left">
                            <ul>
                                <li class="text-bold">Invoiced To:</li>
                                <li><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></li>
                                <li><?php echo htmlspecialchars($booking['email']); ?></li>
                            </ul>
                        </div>
                        <div class="invoice-head-bottom-right">
                            <ul class="text-end">
                                <li class="text-bold">Pay To:</li>
                                <li>L'S Hotel</li>
                                <li>07-8691188</li>
                                <li>info@lshotel.com</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="overflow-view">
                    <div class="invoice-body">
                        <table>
                            <thead>
                                <tr>
                                    <td class="text-bold">ITEMS</td>
                                    <td class="text-bold">Description</td>
                                    <td class="text-bold">Rate</td>
                                    <td class="text-bold">QTY</td>
                                    <td class="text-bold">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['number_of_rooms']); ?> room(s) for <?php echo htmlspecialchars($booking['days']); ?> night(s)</td>
                                    <td>RM <?php echo number_format($booking['room_price'], 2); ?> per room per night</td>
                                    <td><?php echo htmlspecialchars($booking['number_of_rooms'] * $booking['days']); ?></td>
                                    <td class="text-end">RM <?php echo number_format($room_total, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Extra Bed Charge</td>
                                    <td>Extra Bed</td>
                                    <td>RM 10</td>
                                    <td><?php echo $charges['extra_bed_qty']; ?></td>
                                    <td class="text-end">RM <?php echo number_format($charges['extra_bed_total'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Breakfast Charge</td>
                                    <td>Breakfast</td>
                                    <td>RM 35</td>
                                    <td><?php echo $charges['breakfast_qty']; ?></td>
                                    <td class="text-end">RM <?php echo number_format($charges['breakfast_total'], 2); ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-bold">Total</td>
                                    <td class="text-end">RM <?php echo number_format($total_amount, 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="invoice-footer">
                    <ul class="text-center">
                        <li>Thank you for your business</li>
                        <li>If you have any questions about this invoice, please contact us</li>
                        <li>L'S Hotel - 07-8691188 - info@lshotel.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center m-t-20 no-print">
        <button onclick="window.print();" class="btn btn-primary">Print</button>
        <button class="btn btn-secondary" onclick="generatePDF()">Download PDF</button>
        <button id="back-button" class="btn btn-info" onclick="goBack()">Back</button>
    </div>
    <script>
        function generatePDF() {
            var logoBase64 = '<?php echo base64_encode(file_get_contents("img/logo.png")); ?>';
            var docDefinition = {
                content: [
                    {
                        columns: [
                            {
                                image: 'data:image/png;base64,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',
                                width: 150
                            },
                            {
                                text: [
                                    { text: 'Invoice\n', style: 'header' },
                                    { text: 'Date: <?php echo date('d/m/Y'); ?>\n', style: 'subheader' },
                                    { text: 'Invoice No: <?php echo $invoice_id; ?>\n', style: 'subheader' }
                                ],
                                alignment: 'right'
                            }
                        ]
                    },
                    '\n\n',
                    {
                        columns: [
                            {
                                width: '*',
                                text: [
                                    { text: 'Invoiced To:\n', style: 'subheader' },
                                    '<?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?>\n',
                                    '<?php echo htmlspecialchars($booking['email']); ?>\n',
                                ]
                            },
                            {
                                width: '*',
                                text: [
                                    { text: 'Pay To:\n', style: 'subheader' },
                                    'L\'S Hotel\n',
                                    '07-8691188\n',
                                    'info@lshotel.com\n'
                                ],
                                alignment: 'right'
                            }
                        ]
                    },
                    '\n\n',
                    {
                        style: 'tableExample',
                        table: {
                            headerRows: 1,
                            widths: [ '*', 'auto', 100, 'auto', 100 ],
                            body: [
                                [ { text: 'ITEMS', style: 'tableHeader' }, { text: 'Description', style: 'tableHeader' }, { text: 'Rate', style: 'tableHeader' }, { text: 'QTY', style: 'tableHeader' }, { text: 'Amount', style: 'tableHeader' } ],
                                [ '<?php echo htmlspecialchars($booking['room_type']); ?>', '<?php echo htmlspecialchars($booking['number_of_rooms']); ?> room(s) for <?php echo htmlspecialchars($booking['days']); ?> night(s)', 'RM <?php echo number_format($booking['room_price'], 2); ?> per room per night', '<?php echo htmlspecialchars($booking['number_of_rooms'] * $booking['days']); ?>', 'RM <?php echo number_format($room_total, 2); ?>' ],
                                [ 'Extra Bed Charge', 'Extra Bed', 'RM 10', '<?php echo $charges['extra_bed_qty']; ?>', 'RM <?php echo number_format($charges['extra_bed_total'], 2); ?>' ],
                                [ 'Breakfast Charge', 'Breakfast', 'RM 35', '<?php echo $charges['breakfast_qty']; ?>', 'RM <?php echo number_format($charges['breakfast_total'], 2); ?>' ]
                            ]
                        }
                    },
                    '\n\n',
                    {
                        columns: [
                            {
                                width: '*',
                                text: null
                            },
                            {
                                width: 'auto',
                                columns: [
                                    { text: 'Total:', style: 'subheader', alignment: 'right' },
                                    { text: 'RM <?php echo number_format($total_amount, 2); ?>', style: 'subheader', alignment: 'right' }
                                ],
                                layout: 'noBorders'
                            }
                        ]
                    },
                    '\n\n',
                    { text: 'Thank you for your business\nIf you have any questions about this invoice, please contact us\nL\'S Hotel - 07-8691188 - info@lshotel.com', style: 'note', alignment: 'center' }
                ],
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true
                    },
                    subheader: {
                        fontSize: 12,
                        bold: true,
                        margin: [0, 10, 0, 5]
                    },
                    tableExample: {
                        margin: [0, 5, 0, 15]
                    },
                    tableHeader: {
                        bold: true,
                        fontSize: 12,
                        color: 'black'
                    },
                    note: {
                        fontSize: 10,
                        bold: true,
                        alignment: 'center',
                        margin: [0, 10, 0, 0]
                    }
                },
                defaultStyle: {
                    columnGap: 20
                }
            };

            pdfMake.createPdf(docDefinition).download('invoice.pdf');
        }

        function goBack() {
            const referrer = '<?php echo $referrer; ?>';
            if (referrer) {
                if (referrer.includes('payment_success.php')) {
                    window.location.href = 'index.php';
                } else {
                    window.location.href = referrer;
                }
            } else {
                window.location.href = 'index.php';
            }
        }

        // Change the button text if coming from payment_success.php
        document.addEventListener('DOMContentLoaded', (event) => {
            const referrer = '<?php echo $referrer; ?>';
            const backButton = document.getElementById('back-button');
            if (referrer && referrer.includes('payment_success.php')) {
                backButton.innerText = 'Homepage';
            }
        });
    </script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</body>
</html>
