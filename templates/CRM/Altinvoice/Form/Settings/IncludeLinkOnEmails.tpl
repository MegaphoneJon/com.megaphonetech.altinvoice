<table>
  <tr id="include_link_to_pay">
    <td class="label">&nbsp;</td>
    <td>
        {$form.include_link_to_pay.html}
        {$form.include_link_to_pay.label}
    </td>
  </tr>
</table>
<script type="text/javascript">
  {literal}
	CRM.$(function($) {
		targetElement = $('.crm-preferences-form-block-is_email_pdf');
		$('#include_link_to_pay').insertAfter(targetElement);
	});
	{/literal}
</script>
