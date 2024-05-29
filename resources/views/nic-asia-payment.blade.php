<form id="frm-nicasia" action="{{ $nica_url }}" method="post">
    <div class="form-group">
        <input type="hidden" name="access_key" value="{{ $data['access_key'] }}" >
        <input type="hidden" name="profile_id" value="{{ $data['profile_id'] }}" >
        <input type="hidden" name="transaction_uuid" value="{{ $data['transaction_uuid'] }}" >
        <input type="hidden" name="signed_field_names" value="{{ $data['signed_field_names']}}" >
        <input type="hidden" name="unsigned_field_names" value="{{ $data['unsigned_field_names'] }}" >
        <input type="hidden" name="signed_date_time" value="{{ $data['signed_date_time'] }}" >
        <input type="hidden" name="locale" value="{{ $data['locale'] }}" >
        <input type="hidden" name="amount" value="{{ $data['amount'] }}">
        <input type="hidden" name="bill_to_forename" value="{{ $data['bill_to_forename'] }}">
        <input type="hidden" name="bill_to_surname" value="{{ $data['bill_to_surname'] }}">
        <input type="hidden" name="bill_to_email" value="{{ $data['bill_to_email'] }}">
        <input type="hidden" name="bill_to_phone" value="{{ $data['bill_to_phone'] }}">
        <input type="hidden" name="bill_to_address_line1" value="{{ $data['bill_to_address_line1'] }}">
        <input type="hidden" name="bill_to_address_city" value="{{ $data['bill_to_address_city'] }}">
        <input type="hidden" name="bill_to_address_state" value="{{ $data['bill_to_address_state'] }}">
        <input type="hidden" name="bill_to_address_country" value="{{ $data['bill_to_address_country'] }}">
        <input type="hidden" name="ship_to_forename" value="{{ $data['ship_to_forename'] }}">
        <input type="hidden" name="ship_to_surname" value="{{ $data['ship_to_surname'] }}">
        <input type="hidden" name="ship_to_email" value="{{ $data['ship_to_email'] }}">
        <input type="hidden" name="ship_to_phone" value="{{ $data['ship_to_phone'] }}">
        <input type="hidden" name="ship_to_address_line1" value="{{ $data['ship_to_address_line1'] }}">
        <input type="hidden" name="ship_to_address_city" value="{{ $data['ship_to_address_city'] }}">
        <input type="hidden" name="ship_to_address_state" value="{{ $data['ship_to_address_state'] }}">
        <input type="hidden" name="ship_to_address_country" value="{{ $data['ship_to_address_country'] }}">
        <input type="hidden" name="transaction_type" value="{{ $data['transaction_type'] }}">
        <input type="hidden" name="reference_number" value="{{ $data['reference_number'] }}">
        <input type="hidden" name="currency" value="{{ $data['currency'] }}">
        <input type="hidden" name="payment_method" value="{{ $data['payment_method'] }}">
        <input type="hidden" name="signature" value="{{ $data['signature'] }}">
        <input type="hidden" name="card_type" class="form-control" value="001">
        <input type="hidden" name="card_number" class="form-control" >
        <input type="hidden" name="card_expiry_date" class="form-control" >
    </div>
</form>

<script>    
window.onload = function(){
    document.forms['frm-nicasia'].submit();
}
</script>
