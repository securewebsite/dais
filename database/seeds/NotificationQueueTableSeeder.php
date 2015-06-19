<?php

use Illuminate\Database\Seeder;

class NotificationQueueTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('notification_queue')->delete();
        
		\DB::table('notification_queue')->insert(array (
			0 => 
			array (
				'queue_id' => 1,
				'email' => 'vkronlein@icloud.com',
				'name' => 'Vince Kronlein',
				'subject' => 'Your New Customer Account',
				'text' => 'Your Site
========================================

Hi Vince,

Welcome to Your Site.

We’re really happy to have you as a customer and we look forward to serving you.

With your new Your Site account you can track all your orders, re-order a previous order with a single click and if you didn’t do so when you signed up, you can enroll in our affiliate program and earn up to 10% on all the sales you refer to us.

If you have any question don’t be afraid to hit us up by email or by the telephone number below.

Thanks so much,

Your Site Administration
http://dais.local

==========================
Your Site
http://dais.local

77 Massachusetts Ave,
Cambridge, MA 02139
(123) 456-7890
-----------------------------------
You are receiving this because you\'re either a customer
or affiliate of Your Site.

Change your preferences below:
http://dais.local/account/notification/preferences

Unsubscribe:
http://dais.local/account/notification/unsubscribe?id=1
-----------------------------------
http://twitter.com/TwitterHandle
http://www.facebook.com/FacebookPage',
				'html' => '    <title>
Your New Customer Account
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width">
<style type="text/css">
body {
margin: 0;
mso-line-height-rule: exactly;
padding: 0;
min-width: 100%;
}
table {
border-collapse: collapse;
border-spacing: 0;
}
td {
padding: 0;
vertical-align: top;
}
.spacer,
.border {
font-size: 1px;
line-height: 1px;
}
.spacer {
width: 100%;
}
img {
border: 0;
-ms-interpolation-mode: bicubic;
}
.image {
font-size: 12px;
margin-bottom: 24px;
mso-line-height-rule: at-least;
}
.image img {
display: block;
}
.logo {
mso-line-height-rule: at-least;
}
.logo img {
display: block;
}
strong {
font-weight: bold;
}
h1,
h2,
h3,
p,
ol,
ul,
li {
margin-top: 0;
}
ol,
ul,
li {
padding-left: 0;
}
blockquote {
margin-top: 0;
margin-right: 0;
margin-bottom: 0;
padding-right: 0;
}
.column-top {
font-size: 32px;
line-height: 32px;
}
.column-bottom {
font-size: 8px;
line-height: 8px;
}
.column {
text-align: left;
}
.contents {
width: 100%;
}
.padded {
padding-left: 32px;
padding-right: 32px;
}
.wrapper {
display: table;
table-layout: fixed;
width: 100%;
min-width: 620px;
-webkit-text-size-adjust: 100%;
-ms-text-size-adjust: 100%;
}
table.wrapper {
table-layout: fixed;
}
.one-col,
.two-col,
.three-col {
margin-left: auto;
margin-right: auto;
width: 600px;
}
.centered {
margin-left: auto;
margin-right: auto;
}
.two-col .image {
margin-bottom: 23px;
}
.two-col .column-bottom {
font-size: 9px;
line-height: 9px;
}
.two-col .column {
width: 300px;
}
.three-col .image {
margin-bottom: 21px;
}
.three-col .column-bottom {
font-size: 11px;
line-height: 11px;
}
.three-col .column {
width: 200px;
}
.three-col .first .padded {
padding-left: 32px;
padding-right: 16px;
}
.three-col .second .padded {
padding-left: 24px;
padding-right: 24px;
}
.three-col .third .padded {
padding-left: 16px;
padding-right: 32px;
}
@media only screen and (min-width: 0), only screen and (min-device-width: 0) {
.wrapper {
text-rendering: optimizeLegibility;
}
}
@media only screen and (max-width: 620px), only screen and (max-device-width: 620px) {
[class=wrapper] {
min-width: 318px !important;
width: 100% !important;
}
[class=wrapper] .one-col,
[class=wrapper] .two-col,
[class=wrapper] .three-col {
width: 318px !important;
}
[class=wrapper] .column,
[class=wrapper] .gutter {
display: block;
float: left;
width: 318px !important;
}
[class=wrapper] .padded {
padding-left: 32px !important;
padding-right: 32px !important;
}
[class=wrapper] .block {
display: block !important;
}
[class=wrapper] .hide {
display: none !important;
}
[class=wrapper] .image {
margin-bottom: 24px !important;
}
[class=wrapper] .image img {
height: auto !important;
width: 100% !important;
}
}
.wrapper h1 {
font-weight: 700;
}
.wrapper h2 {
font-style: italic;
font-weight: normal;
}
.wrapper h3 {
font-weight: normal;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
font-style: italic;
}
.one-col-feature h1 {
font-weight: normal;
}
.one-col-feature h2 {
font-style: normal;
font-weight: bold;
}
.one-col-feature h3 {
font-style: italic;
}
td.border {
width: 1px;
}
tr.border {
background-color: #e9e9e9;
height: 1px;
}
tr.border td {
line-height: 1px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature {
background-color: #ffffff;
font-size: 14px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature,
.preheader,
.header,
.footer {
margin-left: auto;
margin-right: auto;
}
.preheader table {
width: 602px;
}
.preheader .title,
.preheader .webversion {
padding-top: 10px;
padding-bottom: 12px;
font-size: 12px;
line-height: 21px;
}
.preheader .title {
text-align: left;
}
.preheader .webversion {
text-align: right;
width: 300px;
}
.header {
width: 602px;
}
.header .logo {
padding: 32px 0;
}
.header .logo div {
font-size: 26px;
font-weight: 700;
letter-spacing: -0.02em;
line-height: 32px;
}
.header .logo div a {
text-decoration: none;
}
.header .logo div.logo-center {
text-align: center;
}
.header .logo div.logo-center img {
margin-left: auto;
margin-right: auto;
}
.gmail {
width: 650px;
min-width: 650px;
}
.gmail td {
font-size: 1px;
line-height: 1px;
}
.wrapper a {
text-decoration: underline;
transition: all .2s;
}
.wrapper h1 {
font-size: 36px;
margin-bottom: 18px;
}
.wrapper h2 {
font-size: 26px;
line-height: 32px;
margin-bottom: 20px;
}
.wrapper h3 {
font-size: 18px;
line-height: 22px;
margin-bottom: 16px;
}
.wrapper h1 a,
.wrapper h2 a,
.wrapper h3 a {
text-decoration: none;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
font-size: 14px;
border-left: 2px solid #e9e9e9;
margin-left: 0;
padding-left: 16px;
}
table.divider {
width: 100%;
}
.divider .inner {
padding-bottom: 24px;
}
.divider table {
background-color: #e9e9e9;
font-size: 2px;
line-height: 2px;
width: 60px;
}
.wrapper .gray {
background-color: #f7f7f7;
}
.wrapper .gray blockquote {
border-left-color: #dddddd;
}
.wrapper .gray .divider table {
background-color: #dddddd;
}
.padded .image {
font-size: 0;
}
.image-frame {
padding: 8px;
}
.image-background {
display: inline-block;
font-size: 12px;
}
.btn {
margin-bottom: 24px;
padding: 2px;
}
.btn a {
border: 1px solid #ffffff;
display: inline-block;
font-size: 13px;
font-weight: bold;
line-height: 15px;
outline-style: solid;
outline-width: 2px;
padding: 10px 30px;
text-align: center;
text-decoration: none !important;
}
.one-col .column table:nth-last-child(2) td h1:last-child,
.one-col .column table:nth-last-child(2) td h2:last-child,
.one-col .column table:nth-last-child(2) td h3:last-child,
.one-col .column table:nth-last-child(2) td p:last-child,
.one-col .column table:nth-last-child(2) td ol:last-child,
.one-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 24px;
}
.one-col p,
.one-col ol,
.one-col ul {
font-size: 16px;
line-height: 24px;
}
.one-col ol,
.one-col ul {
margin-left: 18px;
}
.two-col .column table:nth-last-child(2) td h1:last-child,
.two-col .column table:nth-last-child(2) td h2:last-child,
.two-col .column table:nth-last-child(2) td h3:last-child,
.two-col .column table:nth-last-child(2) td p:last-child,
.two-col .column table:nth-last-child(2) td ol:last-child,
.two-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 23px;
}
.two-col .image-frame {
padding: 6px;
}
.two-col h1 {
font-size: 26px;
line-height: 32px;
margin-bottom: 16px;
}
.two-col h2 {
font-size: 20px;
line-height: 26px;
margin-bottom: 18px;
}
.two-col h3 {
font-size: 16px;
line-height: 20px;
margin-bottom: 14px;
}
.two-col p,
.two-col ol,
.two-col ul {
font-size: 14px;
line-height: 23px;
}
.two-col ol,
.two-col ul {
margin-left: 16px;
}
.two-col li {
padding-left: 5px;
}
.two-col .divider .inner {
padding-bottom: 23px;
}
.two-col .btn {
margin-bottom: 23px;
}
.two-col blockquote {
padding-left: 16px;
}
.three-col .column table:nth-last-child(2) td h1:last-child,
.three-col .column table:nth-last-child(2) td h2:last-child,
.three-col .column table:nth-last-child(2) td h3:last-child,
.three-col .column table:nth-last-child(2) td p:last-child,
.three-col .column table:nth-last-child(2) td ol:last-child,
.three-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 21px;
}
.three-col .image-frame {
padding: 4px;
}
.three-col h1 {
font-size: 20px;
line-height: 26px;
margin-bottom: 12px;
}
.three-col h2 {
font-size: 16px;
line-height: 22px;
margin-bottom: 14px;
}
.three-col h3 {
font-size: 14px;
line-height: 18px;
margin-bottom: 10px;
}
.three-col p,
.three-col ol,
.three-col ul {
font-size: 12px;
line-height: 21px;
}
.three-col ol,
.three-col ul {
margin-left: 14px;
}
.three-col li {
padding-left: 6px;
}
.three-col .divider .inner {
padding-bottom: 21px;
}
.three-col .btn {
margin-bottom: 21px;
}
.three-col .btn a {
font-size: 12px;
line-height: 14px;
padding: 8px 19px;
}
.three-col blockquote {
padding-left: 16px;
}
.one-col-feature .column-top {
font-size: 36px;
line-height: 36px;
}
.one-col-feature .column-bottom {
font-size: 4px;
line-height: 4px;
}
.one-col-feature .column {
text-align: center;
width: 600px;
}
.one-col-feature .image {
margin-bottom: 32px;
}
.one-col-feature .column table:nth-last-child(2) td h1:last-child,
.one-col-feature .column table:nth-last-child(2) td h2:last-child,
.one-col-feature .column table:nth-last-child(2) td h3:last-child,
.one-col-feature .column table:nth-last-child(2) td p:last-child,
.one-col-feature .column table:nth-last-child(2) td ol:last-child,
.one-col-feature .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 32px;
}
.one-col-feature h1,
.one-col-feature h2,
.one-col-feature h3 {
text-align: center;
}
.one-col-feature h1 {
font-size: 52px;
margin-bottom: 22px;
}
.one-col-feature h2 {
font-size: 42px;
margin-bottom: 20px;
}
.one-col-feature h3 {
font-size: 32px;
line-height: 42px;
margin-bottom: 20px;
}
.one-col-feature p,
.one-col-feature ol,
.one-col-feature ul {
font-size: 21px;
line-height: 32px;
margin-bottom: 32px;
}
.one-col-feature p a,
.one-col-feature ol a,
.one-col-feature ul a {
text-decoration: none;
}
.one-col-feature p {
text-align: center;
}
.one-col-feature ol,
.one-col-feature ul {
margin-left: 40px;
text-align: left;
}
.one-col-feature li {
padding-left: 3px;
}
.one-col-feature .btn {
margin-bottom: 32px;
text-align: center;
}
.one-col-feature .divider .inner {
padding-bottom: 32px;
}
.one-col-feature blockquote {
border-bottom: 2px solid #e9e9e9;
border-left-color: #ffffff;
border-left-width: 0;
border-left-style: none;
border-top: 2px solid #e9e9e9;
margin-bottom: 32px;
margin-left: 0;
padding-bottom: 42px;
padding-left: 0;
padding-top: 42px;
position: relative;
}
.one-col-feature blockquote:before,
.one-col-feature blockquote:after {
background: -moz-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -webkit-gradient(linear, left top, right top, color-stop(25%, #ffffff), color-stop(25%, #e9e9e9), color-stop(75%, #e9e9e9), color-stop(75%, #ffffff));
background: -webkit-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -o-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -ms-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: linear-gradient(to right, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
content: \'\';
display: block;
height: 2px;
left: 0;
outline: 1px solid #ffffff;
position: absolute;
right: 0;
}
.one-col-feature blockquote:before {
top: -2px;
}
.one-col-feature blockquote:after {
bottom: -2px;
}
.one-col-feature blockquote p,
.one-col-feature blockquote ol,
.one-col-feature blockquote ul {
font-size: 42px;
line-height: 48px;
margin-bottom: 48px;
}
.one-col-feature blockquote p:last-child,
.one-col-feature blockquote ol:last-child,
.one-col-feature blockquote ul:last-child {
margin-bottom: 0 !important;
}
.footer {
width: 602px;
}
.footer .padded {
font-size: 12px;
line-height: 20px;
}
.social {
padding-top: 32px;
padding-bottom: 22px;
}
.social img {
display: block;
}
.social .divider {
font-family: sans-serif;
font-size: 10px;
line-height: 21px;
text-align: center;
padding-left: 14px;
padding-right: 14px;
}
.social .social-text {
height: 21px;
vertical-align: middle !important;
font-size: 10px;
font-weight: bold;
text-decoration: none;
text-transform: uppercase;
}
.social .social-text a {
text-decoration: none;
}
.address {
width: 250px;
}
.address .padded {
text-align: left;
padding-left: 0;
padding-right: 10px;
}
.subscription {
width: 350px;
}
.subscription .padded {
text-align: right;
padding-right: 0;
padding-left: 10px;
}
.address,
.subscription {
padding-top: 32px;
padding-bottom: 64px;
}
.address a,
.subscription a {
font-weight: bold;
text-decoration: none;
}
.address table,
.subscription table {
width: 100%;
}
@media only screen and (max-width: 651px), only screen and (max-device-width: 651px) {
.gmail {
display: none !important;
}
}
@media only screen and (max-width: 620px), only screen and (max-device-width: 620px) {
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ul:last-child {
margin-bottom: 24px !important;
}
[class=wrapper] .address,
[class=wrapper] .subscription {
display: block;
float: left;
width: 318px !important;
text-align: center !important;
}
[class=wrapper] .address {
padding-bottom: 0 !important;
}
[class=wrapper] .subscription {
padding-top: 0 !important;
}
[class=wrapper] h1 {
font-size: 36px !important;
line-height: 42px !important;
margin-bottom: 18px !important;
}
[class=wrapper] h2 {
font-size: 26px !important;
line-height: 32px !important;
margin-bottom: 20px !important;
}
[class=wrapper] h3 {
font-size: 18px !important;
line-height: 22px !important;
margin-bottom: 16px !important;
}
[class=wrapper] p,
[class=wrapper] ol,
[class=wrapper] ul {
font-size: 16px !important;
line-height: 24px !important;
margin-bottom: 24px !important;
}
[class=wrapper] ol,
[class=wrapper] ul {
margin-left: 18px !important;
}
[class=wrapper] li {
padding-left: 2px !important;
}
[class=wrapper] blockquote {
padding-left: 16px !important;
}
[class=wrapper] .two-col .column:nth-child(n + 3) {
border-top: 1px solid #e9e9e9;
}
[class=wrapper] .btn {
margin-bottom: 24px !important;
}
[class=wrapper] .btn a {
display: block !important;
font-size: 13px !important;
font-weight: bold !important;
line-height: 15px !important;
padding: 10px 30px !important;
}
[class=wrapper] .column-bottom {
font-size: 8px !important;
line-height: 8px !important;
}
[class=wrapper] .first .column-bottom,
[class=wrapper] .three-col .second .column-bottom {
display: none;
}
[class=wrapper] .second .column-top,
[class=wrapper] .third .column-top {
display: none;
}
[class=wrapper] .image-frame {
padding: 4px !important;
}
[class=wrapper] .header .logo {
padding-left: 10px !important;
padding-right: 10px !important;
}
[class=wrapper] .header .logo div {
font-size: 26px !important;
line-height: 32px !important;
}
[class=wrapper] .header .logo div img {
display: inline-block !important;
max-width: 280px !important;
height: auto !important;
}
[class=wrapper] table.border,
[class=wrapper] .header,
[class=wrapper] .webversion,
[class=wrapper] .footer {
width: 320px !important;
}
[class=wrapper] .preheader .webversion,
[class=wrapper] .header .logo a {
text-align: center !important;
}
[class=wrapper] .preheader table,
[class=wrapper] .border td {
width: 318px !important;
}
[class=wrapper] .border td.border {
width: 1px !important;
}
[class=wrapper] .image .border td {
width: auto !important;
}
[class=wrapper] .title {
display: none;
}
[class=wrapper] .footer .padded {
text-align: center !important;
}
[class=wrapper] .footer .subscription .padded {
padding-top: 20px !important;
}
[class=wrapper] .footer .social-link {
display: block !important;
}
[class=wrapper] .footer .social-link table {
margin: 0 auto 10px !important;
}
[class=wrapper] .footer .divider {
display: none !important;
}
[class=wrapper] .one-col-feature .btn {
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature .image {
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature .divider .inner {
padding-bottom: 28px !important;
}
[class=wrapper] .one-col-feature h1 {
font-size: 42px !important;
line-height: 48px !important;
margin-bottom: 20px !important;
}
[class=wrapper] .one-col-feature h2 {
font-size: 32px !important;
line-height: 36px !important;
margin-bottom: 18px !important;
}
[class=wrapper] .one-col-feature h3 {
font-size: 26px !important;
line-height: 32px !important;
margin-bottom: 20px !important;
}
[class=wrapper] .one-col-feature p,
[class=wrapper] .one-col-feature ol,
[class=wrapper] .one-col-feature ul {
font-size: 20px !important;
line-height: 28px !important;
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature blockquote {
font-size: 18px !important;
line-height: 26px !important;
margin-bottom: 28px !important;
padding-bottom: 26px !important;
padding-left: 0 !important;
padding-top: 26px !important;
}
[class=wrapper] .one-col-feature blockquote p,
[class=wrapper] .one-col-feature blockquote ol,
[class=wrapper] .one-col-feature blockquote ul {
font-size: 26px !important;
line-height: 32px !important;
}
[class=wrapper] .one-col-feature blockquote p:last-child,
[class=wrapper] .one-col-feature blockquote ol:last-child,
[class=wrapper] .one-col-feature blockquote ul:last-child {
margin-bottom: 0 !important;
}
[class=wrapper] .one-col-feature .column table:last-of-type h1:last-child,
[class=wrapper] .one-col-feature .column table:last-of-type h2:last-child,
[class=wrapper] .one-col-feature .column table:last-of-type h3:last-child {
margin-bottom: 28px !important;
}
}
@media only screen and (max-width: 320px), only screen and (max-device-width: 320px) {
[class=wrapper] td.border {
display: none;
}
[class=wrapper] table.border,
[class=wrapper] .header,
[class=wrapper] .webversion,
[class=wrapper] .footer {
width: 318px !important;
}
}
</style>
<!--[if gte mso 9]>
<style>
.column-top {
mso-line-height-rule: exactly !important;
}
</style>
<![endif]-->
<meta name="robots" content="noindex,nofollow">
<meta property="og:title" content="Your New Customer Account">


<style type="text/css">
body,.wrapper,.emb-editor-canvas{background-color:#e9e8dd}.border{background-color:#d9d8ce}h1{color:#212425}.wrapper h1{}.wrapper h1{font-family:sans-serif}h1{}.one-col h1{line-height:44px}.two-col h1{line-height:32px}.three-col h1{line-height:26px}.wrapper .one-col-feature h1{line-height:58px}@media only screen and (max-width: 620px),only screen and (max-device-width: 620px){h1{line-height:44px !important}}h2{color:#212425}.wrapper h2{}.wrapper h2{font-family:sans-serif}h2{}.one-col h2{line-height:34px}.two-col h2{line-height:26px}.three-col h2{line-height:22px}.wrapper .one-col-feature h2{line-height:50px}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){h2{line-height:34px !important}}h3{color:#212425}.wrapper h3{}.wrapper h3{font-family:sans-serif}h3{}.one-col h3{line-height:26px}.two-col h3{line-height:22px}.three-col h3{line-height:20px}.wrapper .one-col-feature h3{line-height:40px}@media only screen and (max-width:620px), only screen and (max-device-width: 620px){h3{line-height:26px !important}}p,ol,ul{color:#212425}.wrapper p,.wrapper ol,.wrapper ul{}.wrapper p,.wrapper ol,.wrapper ul{font-family:sans-serif}p,ol,ul{}.one-col p,.one-col ol,.one-col ul{line-height:24px;margin-bottom:24px}.two-col p,.two-col ol,.two-col ul{line-height:22px;margin-bottom:22px}.three-col p,.three-col ol,.three-col ul{line-height:20px;margin-bottom:20px}.wrapper .one-col-feature p,.wrapper .one-col-feature ol,.wrapper .one-col-feature ul{line-height:29px}.one-col-feature blockquote p,.one-col-feature blockquote ol,.one-col-feature blockquote ul{line-height:48px}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){p,ol,ul{line-height:24px !important;margin-bottom:24px !important}}.image{color:#212425}.image{font-family:sans-serif}.wrapper a{color:#5ba4e5}.wrapper a:hover{color:#2f8cde !important}.wrapper .logo div{color:#41637e}.wrapper .logo div{font-family:sans-serif}@media only screen and (min-width: 0), only screen and (min-device-width: 0){.wrapper .logo div{font-family:sans-serif !important}}.wrapper .logo div a{color:#41637e}.wrapper .logo div a:hover{color:#41637e !important}.wrapper .one-col-feature p a,.wrapper .one-col-feature ol a,.wrapper .one-col-feature ul a{border-bottom:1px solid #5ba4e5}.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature ol a:hover,.wrapper .one-col-feature ul a:hover{color:#2f8cde !important;border-bottom:1px solid #2f8cde !important}.btn a{}.wrapper .btn a{}.wrapper .btn a{font-family:sans-serif}.wrapper .btn a{background-color:#83969f;color:#fff !important;outline-color:#83969f;text-shadow:0 1px 0 #76878f}.wrapper .btn a:hover{background-color:#76878f !important;color:#fff !important;outline-color:#76878f !important}.preheader .title,.preheader .webversion,.footer .padded{color:#5e5e5e}.preheader .title,.preheader .webversion,.footer .padded{font-family:sans-serif}.preheader .title a,.preheader .webversion a,.footer .padded a{color:#5e5e5e}.preheader .title a:hover,.preheader .webversion a:hover,.footer .padded a:hover{color:#383838 !important}.footer .social .divider{color:#d9d8ce}.footer .social .social-text,.footer .social a{color:#5e5e5e}.wrapper .footer .social .social-text,.wrapper .footer .social a{}.wrapper .footer .social .social-text,.wrapper .footer .social a{font-family:sans-serif}.footer .social .social-text,.footer .social a{}.footer .social .social-text,.footer .social a{letter-spacing:0.05em}.footer .social .social-text:hover,.footer .social a:hover{color:#383838 !important}.image .border{background-color:#c8c8c8}.image-frame{background-color:#dadada}.image-background{background-color:#f7f7f7}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){[class=wrapper] h2.card-store{font-size:14px !important;top: 20px !important;right: 30px !important;}[class=wrapper] h3.card-text{font-size:12px !important;top: 40px !important;right: 30px !important;}[class=wrapper] h3.card-name{font-size:12px !important;bottom: 20px !important;right: 30px !important;}[class=wrapper] h3.card-code{font-size:12px !important;bottom: 6px !important;right: 30px !important;}}
</style>
<center class="wrapper" style="display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #e9e8dd">
<table class="gmail" style="border-collapse: collapse;border-spacing: 0;width: 650px;min-width: 650px">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px">
&nbsp;
</td>
</tr>
</tbody>
</table>
<table class="preheader centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
<table style="border-collapse: collapse;border-spacing: 0;width: 602px">
<tbody>
<tr>
<td class="title" style="padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: left;color: #5e5e5e;font-family: sans-serif">
Your New Customer Account
</td>
<td class="webversion" style="padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: right;width: 300px;color: #5e5e5e;font-family: sans-serif">
No Images? 
<a href="http://dais.local/account/notification/webversion?id=1" class="webversion" style="font-weight:bold;text-decoration:none;">
Click here
</a>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table class="header centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 602px">
<tbody>
<tr>
<td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px">
&nbsp;
</td>
</tr>
<tr>
<td class="logo" style="padding: 32px 0;vertical-align: top;mso-line-height-rule: at-least">
<div class="logo-center" style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header">
<a style="text-decoration: none;transition: all .2s;color: #41637e" href="http://dais.local">
<img style="border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 405px" src="http://dais.local/image/data/email/logo.png" alt="http://dais.local" width="405" height="98">
</a>
</div>
</td>
</tr>
</tbody>
</table>

<table class="border" style="border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #d9d8ce;margin-left: auto;margin-right: auto" width="602">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
​
</td>
</tr>
</tbody>
</table>

<table class="centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto">
<tbody>
<tr>
<td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px">
​
</td>
<td style="padding: 0;vertical-align: top">
<table class="one-col" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;font-size: 14px">
<tbody>
<tr>
<td class="column" style="padding: 0;vertical-align: top;text-align: left">
<div>
<div class="column-top" style="font-size: 32px;line-height: 32px">
&nbsp;
</div>
</div>




<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px">

<div style="margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px">
<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px">
<h1 style="margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px">
Hi Vince
</h1>
</td>
</tr>
</tbody>
</table>
<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px">
<table class="divider" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="inner" style="padding: 0;vertical-align: top;padding-bottom: 24px" align="center">
<table style="border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
&nbsp;
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<p class="p1">
<span style="line-height: 1.428571429;">
Welcome to Your Site.
</span>
</p>
<p class="p2">
<span class="s1">
</span>
</p>
<p class="p2">
<span style="line-height: 1.428571429;">
We’re really happy to have you as a customer and we look forward to serving you.
</span>
<br>
<span class="s1">
</span>
</p>
<p class="p2">
<span style="line-height: 1.428571429;">
With your new Your Site account you can track all your orders, re-order a previous order with a single click and if you didn’t do so when you signed up, you can enroll in our affiliate program and earn up to 10% on all the sales you refer to us.
</span>
<br>
<span class="s1">
</span>
</p>
<p class="p2">
<span style="line-height: 1.428571429;">
If you have any question don’t be afraid to hit us up by email or by the telephone number below.
</span>
<br>
<span class="s1">
</span>
</p>
</div>

</td>
</tr>
</tbody>
</table>

<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px">

<table class="divider" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="inner" style="padding: 0;vertical-align: top;padding-bottom: 24px" align="center">
<table style="border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
&nbsp;
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px">
<p style="margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px">
<em>
Thanks so much,
</em>
</p>
<p style="margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px">
<em>
Your Site Administration
<br>
<a href="http://dais.local" target="_blank">
http://dais.local
</a>
</em>
</p>
</td>
</tr>
</tbody>
</table>

<div class="column-bottom" style="font-size: 8px;line-height: 8px">
&nbsp;
</div>
</td>
</tr>
</tbody>
</table>
</td>
<td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px">
​
</td>
</tr>
</tbody>
</table>

<table class="border" style="border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #d9d8ce;margin-left: auto;margin-right: auto" width="602">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
​
</td>
</tr>
</tbody>
</table>

<div class="spacer" style="font-size: 1px;line-height: 32px;width: 100%">
&nbsp;
</div>
<table class="footer centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 602px">
<tbody>
<tr>
<td class="social" style="padding: 0;vertical-align: top;padding-top: 32px;padding-bottom: 22px" align="center">
<table style="border-collapse: collapse;border-spacing: 0">
<tbody>
<tr>
<td class="social-link" style="padding: 0;vertical-align: top">
<table style="border-collapse: collapse;border-spacing: 0">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
<fblike style="text-decoration:none;">
<img style="border: 0;-ms-interpolation-mode: bicubic;display: block" src="http://dais.local/image/data/email/facebook-dark.png" width="26" height="21">
</fblike>
</td>
<td class="social-text" style="padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #5e5e5e;letter-spacing: 0.05em;font-family: sans-serif">
<a href="http://www.facebook.com/FacebookPage" class="fblike" style="text-decoration:none;">
Like
</a>
</td>
</tr>
</tbody>
</table>
</td>
<td class="divider" style="padding: 0;vertical-align: top;font-family: sans-serif;font-size: 10px;line-height: 21px;text-align: center;padding-left: 14px;padding-right: 14px;color: #d9d8ce">
<img style="border: 0;-ms-interpolation-mode: bicubic;display: block" src="http://dais.local/image/data/email/diamond.png" width="5" height="21" alt="">
</td>
<td class="social-link" style="padding: 0;vertical-align: top">
<table style="border-collapse: collapse;border-spacing: 0">
<tbody>
<tr>
<td style="padding: 0;vertical-align: top">
<tweet style="text-decoration:none;">
<img style="border: 0;-ms-interpolation-mode: bicubic;display: block" src="http://dais.local/image/data/email/twitter-dark.png" width="26" height="21">
</tweet>
</td>
<td class="social-text" style="padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #5e5e5e;letter-spacing: 0.05em;font-family: sans-serif">
<a href="http://twitter.com/TwitterHandle" class="tweet" style="text-decoration:none;">
Tweet
</a>
</td>
</tr>
</tbody>
</table>
</td>

</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px">
&nbsp;
</td>
</tr>
<tr>
<td style="padding: 0;vertical-align: top">
<table style="border-collapse: collapse;border-spacing: 0">
<tbody>
<tr>
<td class="address" style="padding: 0;vertical-align: top;width: 250px;padding-top: 32px;padding-bottom: 64px">
<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left: 0;padding-right: 10px;text-align: left;font-size: 12px;line-height: 20px;color: #5e5e5e;font-family: sans-serif">
<div>
Your Site
<br>
77 Massachusetts Ave,<br />
Cambridge, MA 02139
<br>
(123) 456-7890
</div>
</td>
</tr>
</tbody>
</table>
</td>
<td class="subscription" style="padding: 0;vertical-align: top;width: 350px;padding-top: 32px;padding-bottom: 64px">
<table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
<tbody>
<tr>
<td class="padded" style="padding: 0;vertical-align: top;padding-left: 10px;padding-right: 0;font-size: 12px;line-height: 20px;color: #5e5e5e;font-family: sans-serif;text-align: right">
<div>
You\'re receiving this email because you\'re either a customer or affiliate of Your Site. Change your preferences below.
</div>
<div>
<span class="block">
<span>
<a href="http://dais.local/account/notification/preferences" class="preferences" style="font-weight:bold;text-decoration:none;" lang="en">
Preferences
</a>
<span class="hide">
&nbsp;&nbsp;|&nbsp;&nbsp;
</span>
</span>
</span>
<span class="block">
<a href="http://dais.local/account/notification/unsubscribe?id=1" class="unsubscribe" style="font-weight:bold;text-decoration:none;">
Unsubscribe
</a>
</span>
</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</center>

',
				'sent' => 1,
				'date_added' => '2015-04-22 21:38:16',
				'date_sent' => '2015-04-22 21:42:53',
			),
		));
	}

}
