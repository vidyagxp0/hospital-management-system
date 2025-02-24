<script id="billActionTemplate" type="text/x-jsrender">

<a href="{{:url}}" title="<?php echo __('messages.common.edit') ?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                        </svg></span>
    </a>
    <a href="javascript:void(0)" title="<?php echo __('messages.common.delete') ?>" data-id={{:id}}" class="delete-btn btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                        <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" /></g></svg></span>
    </a>




</script>

<script id="billItemTemplate" type="text/x-jsrender">
<tr>
    <td class="text-center item-number">1</td>
    <td class="table__item-desc">
        <input class="form-control itemName" required="" name="item_name[]" type="text" placeholder="<?php echo __('messages.ipd_patient_prescription.dosage') ?>">
    </td>
    <td class="table__qty">
        <input class="form-control qty quantity" required="" name="qty[]" type="number">
    </td>
    <td>
        <input class="form-control price-input price" required="" name="price[]" type="text">
    </td>
    <td class="amount text-right itemTotal">
    </td>
    <td class="text-center">
        <i class="fa fa-trash text-danger delete-bill-bulk-item pointer"></i>
    </td>
</tr>


</script>


<script id="medicineBillTemplate" type="text/x-jsrender">
    <tr>
    <td class="table__item-desc">
            <!-- <select class="form-select medicinebillCategories select2Selector" name="category_id[]" data-id="{{:uniqueId}}" required id="categoryChooseId{{:uniqueId}}" > -->
            <select class="form-select medicinebillCategories select2Selector medicineBillCategoriesId" name="category_id[]" data-id="{{:uniqueId}}" required id="categoryChooseId{{:uniqueId}}" >
            <option value="" disabled selected>Select your option</option>
                {{for medicinesCategories}}
                    <option value="{{:key}}">{{:value}}</option>
                {{/for}}
            </select>
        </td>
        <td class="table__item-desc">
            <!-- <select class="form-select purchaseMedicineId select2Selector" name="medicine[]" data-id="{{:uniqueId}}" required id="medicineChooseId{{:uniqueId}}" >
                <option value="" disabled selected>Select your option</option>
                {{for medicines}}
                    <option value="{{:key}}">{{:value}}</option>
                {{/for}}
            </select> -->
            <select class="form-select medicinePurchaseId purchaseMedicineId" name="medicine[]" data-id="{{:uniqueId}}" required >
                <!-- <option value="" disabled selected>Select your option</option> -->
            </select>
        </td>
        <!-- <td>
            <input class="form-control" placeholder="Lot no." required="" name="lot_no[]" type="text" id="lot_no{{:uniqueId}}">
        </td> -->
        <td>
            <input class="form-control medicineBillExpiryDate" placeholder="Expiry Date" name="expiry_date[]"  id="expiry_date{{:uniqueId}}" type="text">
        </td>
        <td>
            <input class="form-control medicineBill-sale-price" required="" value='0.00' name="sale_price[]" id="medicine_sale_price{{:uniqueId}}" type="text">
        </td>
        <td>
            <div class="input-group">
                <input type="number" class="form-control medicineBill-quantity" required="" value='0' name="quantity[]"  id="quantity{{:uniqueId}}">
                <span class="input-group-text ms-0" id="medicineAvailableQuantity{{:uniqueId}}">0</span>
            </div>
        </td>
            <td>
            <div class="input-group">
            <input type="number" class="form-control medicineBill-tax" value='0'  name="tax_medicine[]"  id="tax{{:uniqueId}}">
             <span class="input-group-text ms-0" id="amountTypeSymbol">%</span>
            </div>
        </td>
                <td>
            <input type="number" class="form-control medicine-bill-amount" readonly required="" value='0.00' name="amount[]" id="amount{{:uniqueId}}">
        </td>purchaseMedicineTemplate
        <td class="text-center">
            <a href="javascript:void(0)" title="{{__('messages.common.delete')}}"
               class="delete-medicine-bill-item  btn px-1 text-danger fs-3 pe-0">
                     <i class="fa-solid fa-trash"></i>
            </a>
        </td>
    </tr>

</script>
