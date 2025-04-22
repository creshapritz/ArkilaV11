<h2 style="color: #2c3e50;">New Car Request from ARKILA Partner</h2>

<p>Dear Admin,</p>

<p>
A new vehicle request has been submitted by one of your trusted ARKILA partners. Below are the details of the vehicle they would like to add to the system:
</p>

<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">
    <tbody>
        <tr>
            <td style="padding: 4px;"><strong>Submitted By (Partner Email):</strong></td>
            <td style="padding: 4px;">{{ $sender_email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Company Name:</strong></td>
            <td style="padding: 4px;">{{ $company_name }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Vehicle Name:</strong></td>
            <td style="padding: 4px;">{{ $name }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Brand:</strong></td>
            <td style="padding: 4px;">{{ $brand }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Type:</strong></td>
            <td style="padding: 4px;">{{ $type }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Location:</strong></td>
            <td style="padding: 4px;">{{ $location }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Price per Day:</strong></td>
            <td style="padding: 4px;">₱{{ number_format($price_per_day, 2) }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Seating Capacity:</strong></td>
            <td style="padding: 4px;">{{ $seating_capacity }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Number of Bags:</strong></td>
            <td style="padding: 4px;">{{ $num_bags }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Gas Type:</strong></td>
            <td style="padding: 4px;">{{ $gas_type }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Transmission:</strong></td>
            <td style="padding: 4px;">{{ $transmission }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Plate Number:</strong></td>
            <td style="padding: 4px;">{{ $platenum }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Mileage:</strong></td>
            <td style="padding: 4px;">{{ $mileage }} km</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Color:</strong></td>
            <td style="padding: 4px;">{{ $color }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>Registration Expiry:</strong></td>
            <td style="padding: 4px;">{{ \Carbon\Carbon::parse($regexpiry)->format('F d, Y') }}</td>
        </tr>
    </tbody>
</table>

<p style="margin-top: 20px;">
Please review the request in the admin dashboard and take appropriate action.
</p>

<p>Thank you,<br>
<span style="font-weight: bold;">ARKILA Partner Team</span>
</p>
