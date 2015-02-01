-- MySQL dump 10.15  Distrib 10.0.14-MariaDB, for Linux (i686)
--
-- Host: localhost    Database: biscuit
-- ------------------------------------------------------
-- Server version	10.0.14-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `0_menu`
--

DROP TABLE IF EXISTS `0_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `0_menu` (
  `menu` varchar(60) NOT NULL DEFAULT '',
  `id` varchar(255) NOT NULL DEFAULT '',
  `parent` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `access` varchar(60) DEFAULT '',
  `type` varchar(60) DEFAULT '',
  `weight` int(11) NOT NULL DEFAULT '0',
  `inactive` tinyint(1) NOT NULL DEFAULT '0',
  `params` varchar(255) DEFAULT '',
  PRIMARY KEY (`menu`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `0_menu`
--

LOCK TABLES `0_menu` WRITE;
/*!40000 ALTER TABLE `0_menu` DISABLE KEYS */;
INSERT INTO `0_menu` VALUES ('default','dashboard','','Dashboard','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales','','&Sales','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_orders','sales','Orders / Quotations','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_order_inquiry','sales_orders','Sales Order &Inquiry','sales/inquiry/sales_orders_view.php?type=30','SA_SALESTRANSVIEW','inquiryinquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_order_entry','sales_orders','Sales &Order Entry','sales/sales_order_entry.php?NewOrder=Yes','SA_SALESORDER','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_quot_inquiry','sales_orders','Sales Quotation I&nquiry','sales/inquiry/sales_orders_view.php?type=32','SA_SALESTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_quot_entry','sales_orders','Sales &Quotation Entry','sales/sales_order_entry.php?NewQuotation=Yes','SA_SALESQUOTE','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_delivery_against','sales_orders','&Delivery Against Sales Orders','sales/inquiry/sales_orders_view.php?OutstandingOnly=1','SA_SALESDELIVERY','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_deliveries','sales','&Deliveries','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_delivery_entry','sales_deliveries','Direct &Delivery','sales/sales_order_entry.php?NewDelivery=0','SA_SALESDELIVERY','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_delivery_template','sales_deliveries','&Template Delivery','sales/inquiry/sales_orders_view.php?DeliveryTemplates=Yes','SA_SALESDELIVERY','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_invoice_against','sales_deliveries','&Invoice Against Sales Delivery','sales/inquiry/sales_deliveries_view.php?OutstandingOnly=1','SA_SALESINVOICE','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_invoices','sales','Invoices','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','customer_transactions','sales_invoices','Customer Transactions','sales/inquiry/customer_inquiry.php?','SA_SALESTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','customer_allocations','sales_invoices','Customer Allocations','sales/inquiry/customer_allocation_inquiry.php?','SA_SALESALLOC','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_invoice_entry','sales_invoices','Direct &Invoice','sales/sales_order_entry.php?NewInvoice=0','SA_SALESINVOICE','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_invoice_recurrent','sales_invoices','Recurrent Invoices','sales/create_recurrent_invoices.php?','SA_SALESINVOICE','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_recurrent','sales_invoices','Recurrent &Invoices Setup','sales/manage/recurrent_invoices.php?','SA_SRECURRENT','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_invoice_template','sales_invoices','&Template Invoice','sales/inquiry/sales_orders_view.php?InvoiceTemplates=Yes','SA_SALESINVOICE','unknown',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_payments','sales','Payments','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','costomer_payment_entry','sales_payments','Customer Payments or Credit Notes','sales/allocations/customer_allocation_main.php?','SA_SALESALLOC','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','customer_payments','sales_payments','Customer &Payments','sales/customer_payments.php?','SA_SALESPAYMNT','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','customer_credits','sales_payments','Customer &Credit Notes','sales/credit_note_entry.php?NewCredit=Yes','SA_SALESCREDIT','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_customers','sales','Customers','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','customers','sales_customers','&Customers','sales/manage/customers.php?','SA_CUSTOMER','index',0,0,'');
INSERT INTO `0_menu` VALUES ('default','branches','sales_customers','Customer &Branches','sales/manage/customer_branches.php?','SA_CUSTOMER','index',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_groups','sales_customers','Sales &Groups','sales/manage/sales_groups.php?','SA_SALESGROUP','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_types','sales_customers','Sales T&ypes','sales/manage/sales_types.php?','SA_SALESTYPES','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_areas','sales_customers','Sales &Areas','sales/manage/sales_areas.php?','SA_SALESAREA','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_persons','sales_customers','Sales &Persons','sales/manage/sales_people.php?','SA_SALESMAN','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_credits','sales_customers','Credit &Status Setup','sales/manage/credit_status.php?','SA_CRSTATUS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_reports','sales','Reports','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','customer_reports','sales_reports','Customer and Sales &Reports','reporting/reports_main.php?Class=0','SA_SALESTRANSVIEW','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase','','&Purchases','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_orders','purchase','Orders','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_order_inquiry','purchase_orders','Purchase Orders &Inquiry','purchasing/inquiry/po_search_completed.php?','SA_SUPPTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_order_entry','purchase_orders','Purchase &Order Entry','purchasing/po_entry_items.php?NewOrder=Yes','SA_PURCHASEORDER','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_deliveries','purchase','Deliveries','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_invoice_against','purchase_deliveries','Supplier &Invoices','purchasing/supplier_invoice.php?New=1','SA_SUPPLIERINVOICE','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_grn_entry','purchase_deliveries','Direct &GRN','purchasing/po_entry_items.php?NewGRN=Yes','SA_GRN','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_orders_out','purchase_deliveries','&Outstanding Purchase Orders Maintenance','purchasing/inquiry/po_search.php?','SA_GRN','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_invoices','purchase','Invoices','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','supplier_transactions','purchase_invoices','Supplier Transactions','purchasing/inquiry/supplier_inquiry.php?','SA_SUPPTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','supplier_allocations','purchase_invoices','Supplier Allocations','purchasing/inquiry/supplier_allocation_inquiry.php?','SA_SUPPLIERALLOC','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_invoice_entry','purchase_invoices','Direct &Invoice','purchasing/po_entry_items.php?NewInvoice=Yes','SA_SUPPLIERINVOICE','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_payments','purchase','Payments','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','supplier_payments','purchase_payments','Supplier Payments or Credit Notes','purchasing/allocations/supplier_allocation_main.php?','SA_SUPPLIERALLOC','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','supplier_payment_entry','purchase_payments','&Payments to Suppliers','purchasing/supplier_payment.php?','SA_SUPPLIERPAYMNT','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_suppliers','purchase','&Suppliers','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','suppliers','purchase_suppliers','&Suppliers','purchasing/manage/suppliers.php?','SA_SUPPLIER','index',0,0,'');
INSERT INTO `0_menu` VALUES ('default','purchase_reports','purchase','&Reports','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','supplier_reports','purchase_reports','Supplier and Purchasing &Reports','reporting/reports_main.php?Class=1','SA_SUPPTRANSVIEW','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','inventory','','&Inventory','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','inventory_items','inventory','&Items','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','items','inventory_items','&Items','inventory/manage/items.php?','SA_ITEM','index',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_categories','inventory_items','Item &Categories','inventory/manage/item_categories.php?','SA_ITEMCATEGORY','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_units','inventory_items','&Units of Measure','inventory/manage/item_units.php?','SA_UOM','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_kits','inventory_items','Sales &Kits','inventory/manage/sales_kits.php?','SA_SALESKIT','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_codes','inventory_items','&Foreign Item Codes','inventory/manage/item_codes.php?','SA_FORITEMCODE','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','inv_movements','inventory','Transfers / Adjustments','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_movements','inv_movements','Item &Movements','inventory/inquiry/stock_movements.php?','SA_ITEMSTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_transfer','inv_movements','Location &Transfers','inventory/transfers.php?NewTransfer=1','SA_LOCATIONTRANSFER','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_adjustment','inv_movements','&Adjustments','inventory/adjustments.php?NewAdjustment=1','SA_INVENTORYADJUSTMENT','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','locations','inv_movements','&Locations','inventory/manage/locations.php?','SA_INVENTORYLOCATION','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','movement_types','inv_movements','&Movement Types','inventory/manage/movement_types.php?','SA_INVENTORYMOVETYPE','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','inv_status','inventory','Status','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_status','inv_status','Item &Status','inventory/inquiry/stock_status.php?','SA_ITEMSSTATVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','reorder_levels','inv_status','&Reorder Levels','inventory/reorder_level.php?','SA_REORDER','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','pricing','inventory','Pricing','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','pricing_sales','pricing','Sales &Pricing','inventory/prices.php?','SA_SALESPRICE','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','pricing_purchase','pricing','Purchasing &Pricing','inventory/purchasing_data.php?','SA_PURCHASEPRICING','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','standard_costs','pricing','Standard &Costs','inventory/cost_update.php?','SA_STANDARDCOST','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','inventory_reports','inventory','&Reports','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','item_reports','inventory_reports','Item &Reports','reporting/reports_main.php?Class=2','SA_ITEMSTRANSVIEW','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','manufacturing','','&Manufacturing','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','work_orders','manufacturing','Work Orders','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','work_order_inquiry','work_orders','Work Order &Inquiry','manufacturing/search_work_orders.php?','SA_MANUFTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','work_orders_out','work_orders','&Outstanding Work Orders','manufacturing/search_work_orders.php?outstanding_only=1','A_MANUFTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','work_order_entry','work_orders','Work &Order Entry','manufacturing/work_order_entry.php?','SA_WORKORDERENTRY','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','man_bom','manufacturing','&Bills Of Material','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','bom','man_bom','&Bills Of Material','manufacturing/manage/bom_edit.php?','SA_BOM','index',0,0,'');
INSERT INTO `0_menu` VALUES ('default','bom_costed','man_bom','Costed Bill Of Material Inquiry','manufacturing/inquiry/bom_cost_inquiry.php?','SA_WORKORDERCOST','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','bom_used','man_bom','Inventory Item Where Used &Inquiry','manufacturing/inquiry/where_used_inquiry.php?','SA_WORKORDERANALYTIC','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','work_centres','man_bom','&Work Centres','manufacturing/manage/work_centres.php?','SA_WORKCENTRES','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','man_reports','manufacturing','Reports','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','manufacturing_reports','man_reports','Manufacturing &Reports','reporting/reports_main.php?Class=3','SA_MANUFTRANSVIEW','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl','','&General Ledger','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','journal','gl','Journal','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','journal_inquiry','journal','&Journal Inquiry','gl/inquiry/journal_inquiry.php?','SA_GLANALYTIC','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','journal_entry','journal','&Journal Entry','gl/gl_journal.php?NewJournal=Yes','SA_JOURNALENTRY','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','budget_entry','journal','&Budget Entry','gl/gl_budget.php?','SA_BUDGETENTRY','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','accruals','journal','Revenue / &Costs Accruals','gl/accruals.php?','SA_ACCRUALS','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','banking','gl','Banking','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','bank_statement','banking','Bank Account &Inquiry','gl/inquiry/bank_inquiry.php?','SA_BANKTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','deposit','banking','&Deposits','gl/gl_bank.php?NewDeposit=Yes','SA_DEPOSIT','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','payment','banking','&Payments','gl/gl_bank.php?NewPayment=Yes','SA_PAYMENT','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','transfer','banking','Bank Account &Transfers','gl/bank_transfer.php?','SA_BANKTRANSFER','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','bank_accounts','banking','Bank &Accounts','gl/manage/bank_accounts.php?','SA_BANKACCOUNT','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','bank_account_reconcile','banking','&Reconcile Bank Account','gl/bank_account_reconcile.php?','SA_RECONCILE','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','taxes','gl','Taxes','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','tax_inquiry','taxes','Ta&x Inquiry','gl/inquiry/tax_inquiry.php?','SA_TAXREP','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','tax_types','taxes','&Taxes','taxes/tax_types.php?','SA_TAXRATES','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','tax_groups','taxes','Tax &Groups','taxes/tax_groups.php?','SA_TAXGROUPS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','tax_items','taxes','Item Ta&x Types','taxes/item_tax_types.php?','SA_ITEMTAXTYPE','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl2','gl','Genereal Ledger','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_inquiry','gl2','GL &Inquiry','gl/inquiry/gl_account_inquiry.php?','SA_GLTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','trial_balance','gl2','Trial &Balance','gl/inquiry/gl_trial_balance.php?','SA_GLANALYTIC','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','balance_sheet','gl2','Balance &Sheet Drilldown','gl/inquiry/balance_sheet.php?','SA_GLANALYTIC','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','profit_loss','gl2','&Profit and Loss Drilldown','gl/inquiry/profit_loss.php?','SA_GLANALYTIC','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_accounts','gl','GL Accounts','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_account_analytic','gl_accounts','&GL Accounts','gl/manage/gl_accounts.php?','SA_GLACCOUNT','index',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_account_groups','gl_accounts','GL Account &Groups','gl/manage/gl_account_types.php?','SA_GLACCOUNTGROUP','maintenance',1,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_account_classes','gl_accounts','GL Account &Classes','gl/manage/gl_account_classes.php?','SA_GLACCOUNTCLASS','maintenance',-1,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_account_tags','gl_accounts','Account &Tags','admin/tags.php?type=account','SA_GLACCOUNTTAGS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','dimensions','gl','&Dimensions','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','dimension_inquiry','dimensions','Dimension &Inquiry','dimensions/inquiry/search_dimensions.php?','SA_DIMTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','dimensions_out','dimensions','&Outstanding Dimensions','dimensions/inquiry/search_dimensions.php?outstanding_only=1','SA_DIMTRANSVIEW','inquiry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','dimension_entry','dimensions','Dimension &Entry','dimensions/dimension_entry.php?','SA_DIMENSION','entry',0,0,'');
INSERT INTO `0_menu` VALUES ('default','dimension_tags','dimensions','Dimension &Tags','admin/tags.php?type=dimension','SA_DIMTAGS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','dimension_reports','dimensions','Dimension &Reports','reporting/reports_main.php?Class=4','SA_DIMENSIONREP','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_currencies','gl','Exchange Rates','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','exchange_rates','gl_currencies','&Exchange Rates','gl/manage/exchange_rates.php?','SA_EXCHANGERATE','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','currencies','gl_currencies','&Currencies','gl/manage/currencies.php?','SA_CURRENCY','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','currency_revaluate','gl_currencies','&Revaluation of Currency Accounts','gl/manage/revaluate_currencies.php?','SA_EXCHANGERATE','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_reports','gl','Reports','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','ledger_reports','gl_reports','General Ledger &Reports','reporting/reports_main.php?Class=6','SA_GLREP','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','banking_reports','gl_reports','Banking &Reports','reporting/reports_main.php?Class=5','SA_BANKREP','report',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup','','S&etup','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup_company','setup','&Company and System','','','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','company_setup','setup_company','&Company Setup','admin/company_preferences.php?','SA_SETUPCOMPANY','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','gl_setup','setup_company','System and &General GL Setup','admin/gl_setup.php?','SA_GLSETUP','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','forms_setup','setup_company','&Forms Setup','admin/forms_setup.php?','SA_FORMSETUP','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup_display','setup','&Display','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','display_setup','setup_display','&Display Setup','admin/display_prefs.php?','SA_SETUPDISPLAY','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','print_profiles','setup_display','&Print Profiles','admin/print_profiles.php?','SA_PRINTPROFILE','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','printers','setup_display','&Printers','admin/printers.php?','SA_PRINTERS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup_fiscal_years','setup','&Fiscal Years','admin/fiscalyears.php?','SA_FISCALYEARS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','fiscal_years','setup_fiscal_years','&Fiscal Years','admin/fiscalyears.php?','SA_FISCALYEARS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','misc','setup','Miscellaneous','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','payment_setup','misc','Pa&yment Terms','admin/payment_terms.php?','SA_PAYTERMS','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','shipping_companies','misc','Shi&pping Company','admin/shipping_companies.php?','SA_SHIPPING','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','sales_points','misc','&Points of Sale','sales/manage/sales_points.php?','SA_POSSETUP','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','crm_categories','misc','Contact &Categories','admin/crm_categories.php?','SA_CRMCATEGORY','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup_trans','setup','Transactions','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','transactions','setup_trans','View or &Print Transactions','admin/view_print_transaction.php?','SA_VIEWPRINTTRANSACTION','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','void_transaction','setup_trans','&Void a Transaction','admin/void_transaction.php?','SA_VOIDTRANSACTION','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','attach_documents','setup_trans','&Attach Documents','admin/attachments.php?filterType=20','SA_ATTACHDOCUMENT','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','quick_entries','setup_trans','&Quick Entries','gl/manage/gl_quick_entries.php?','SA_QUICKENTRY','maintenance',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup_users','setup','&Users','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','change_password','setup_users','Change Password','admin/change_current_user_password.php?','SA_USERS','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','user_setup','setup_users','&User Accounts Setup','admin/users.php?','SA_USERS','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','access_setup','setup_users','&Access Setup','admin/security_roles.php?','SA_SECROLES','setup',0,0,'');
INSERT INTO `0_menu` VALUES ('default','setup_ext','setup','Extensions','','','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','backups','setup_ext','&Backup and Restore','admin/backups.php?','SA_BACKUP','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','companies','setup_ext','Create/Update &Companies','admin/create_coy.php?','SA_CREATECOMPANY','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','languages','setup_ext','Install/Update &Languages','admin/inst_lang.php?','SA_CREATELANGUAGE','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','modules','setup_ext','Install/Activate &Extensions','admin/inst_module.php?','SA_CREATEMODULES','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','themes','setup_ext','Install/Activate &Themes','admin/inst_theme.php?','SA_CREATEMODULES','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','charts','setup_ext','Install/Activate &Chart of Accounts','admin/inst_chart.php?','SA_CREATEMODULES','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','upgrade','setup_ext','Software &Upgrade','admin/inst_upgrade.php?','SA_SOFTWAREUPGRADE','',0,0,'');
INSERT INTO `0_menu` VALUES ('default','diagnostic','setup_ext','System &Diagnostics','admin/system_diagnostics.php?','SA_SOFTWAREUPGRADE','',0,0,'');
/*!40000 ALTER TABLE `0_menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-22 21:40:07
