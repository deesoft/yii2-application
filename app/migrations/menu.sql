--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.15
-- Dumped by pg_dump version 9.1.15
-- Started on 2015-04-17 13:12:13 WIB

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;


--
-- TOC entry 2110 (class 0 OID 28961)
-- Dependencies: 191 2128
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: mdmunir
--

INSERT INTO menu VALUES (1, 'Dashboard', NULL, NULL, NULL, NULL);
INSERT INTO menu VALUES (2, 'Admin', NULL, NULL, 0, NULL);
INSERT INTO menu VALUES (3, 'Master', NULL, NULL, 1, NULL);
INSERT INTO menu VALUES (4, 'Purchase', NULL, NULL, 2, NULL);
INSERT INTO menu VALUES (5, 'Inventory', NULL, NULL, 3, NULL);
INSERT INTO menu VALUES (6, 'Sales', NULL, NULL, 4, NULL);
INSERT INTO menu VALUES (7, 'Fi & Accounting', NULL, NULL, 5, NULL);
INSERT INTO menu VALUES (9, 'Orgn', 3, '/master/orgn/index', 1, NULL);
INSERT INTO menu VALUES (10, 'Branch', 3, '/master/branch/index', 2, NULL);
INSERT INTO menu VALUES (11, 'Customer', 3, '/master/customer/index', 3, NULL);
INSERT INTO menu VALUES (12, 'Supplier', 3, '/master/supplier/index', 4, NULL);
INSERT INTO menu VALUES (13, 'Uom', 3, '/master/uom/index', 5, NULL);
INSERT INTO menu VALUES (14, 'Product', 3, NULL, 6, NULL);
INSERT INTO menu VALUES (15, 'Categories', 14, '/master/category/index', 1, NULL);
INSERT INTO menu VALUES (16, 'Groups', 14, '/master/product-group/index', 2, NULL);
INSERT INTO menu VALUES (17, 'Product Detail', 14, '/master/product/index', 3, NULL);
INSERT INTO menu VALUES (18, 'Routes', 2, '/admin/route/index', 1, NULL);
INSERT INTO menu VALUES (19, 'Roles', 2, '/admin/role/index', 2, NULL);
INSERT INTO menu VALUES (8, 'Asignment', 2, '/admin/assignment/index', 3, NULL);
INSERT INTO menu VALUES (20, 'Menus', 2, '/admin/menu/index', 4, NULL);
INSERT INTO menu VALUES (21, 'Warehouses', 3, '/master/warehouse/index', 7, NULL);
INSERT INTO menu VALUES (24, 'Goods Movement', 5, '/inventory/movement/index', 1, NULL);
INSERT INTO menu VALUES (26, 'Branch to Branch', 25, NULL, 1, NULL);
INSERT INTO menu VALUES (27, 'Material to Material', 25, NULL, 2, NULL);
INSERT INTO menu VALUES (28, 'Stock Adjusment', 5, NULL, 3, NULL);
INSERT INTO menu VALUES (29, 'Coa', 7, '/accounting/coa/index', 1, NULL);
INSERT INTO menu VALUES (32, 'Cash In', 31, '/accounting/payment/cash-in', 1, NULL);
INSERT INTO menu VALUES (33, 'Cash Out', 31, '/accounting/payment/cash-out', 2, NULL);
INSERT INTO menu VALUES (34, 'Bank In', 31, '/accounting/payment/bank-in', 3, NULL);
INSERT INTO menu VALUES (35, 'Bank Out', 31, '/accounting/payment/bank-out', 4, NULL);
INSERT INTO menu VALUES (36, 'Entri GL', 7, '/accounting/gl/create', 4, NULL);
INSERT INTO menu VALUES (40, 'Price Groups', 39, '/master/price-category/index', 1, NULL);
INSERT INTO menu VALUES (41, 'Sales Price', 39, '/master/price/index', 2, NULL);
INSERT INTO menu VALUES (38, 'Standart SO', 6, '/sales/sales/create', 2, NULL);
INSERT INTO menu VALUES (39, 'Price Management', 6, NULL, 1, NULL);
INSERT INTO menu VALUES (31, 'Receipt & Payment', 7, NULL, 3, NULL);
INSERT INTO menu VALUES (30, 'Periodes', 43, '/accounting/periode/index', NULL, NULL);
INSERT INTO menu VALUES (43, 'Periodes Control', 7, NULL, 2, NULL);
INSERT INTO menu VALUES (44, 'Closing', 43, '/accounting/gl/closing', 2, NULL);
INSERT INTO menu VALUES (23, 'Purchase Orders', 4, '/purchase/purchase/index', 1, NULL);
INSERT INTO menu VALUES (46, 'Purchase Invoices', 4, '/accounting/invoice/index', 3, NULL);
INSERT INTO menu VALUES (25, 'Stock Transfer', 5, '/inventory/transfer/index', 2, NULL);
INSERT INTO menu VALUES (45, 'Goods Receipt', 4, '/inventory/movement/po-receipt', 2, NULL);


--
-- TOC entry 2136 (class 0 OID 0)
-- Dependencies: 192
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: mdmunir
--

SELECT pg_catalog.setval('menu_id_seq', 46, true);
