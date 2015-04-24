<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

// Heading
$_['lang_heading_title']             = 'Events';

// Text
$_['lang_text_no_results']           = 'There are no events to display.';
$_['lang_text_no_results2']          = 'There are no attendees on the wait list for this event.';
$_['lang_text_no_presenters']        = 'There are no presenters to display.';
$_['lang_text_no_attendees']         = 'There are no attendees registered for this event.';
$_['lang_text_yes']                  = 'Yes';
$_['lang_text_no']                   = 'No';
$_['lang_text_roster']               = 'Roster';
$_['lang_text_event_name']           = 'Event Name: ';
$_['lang_text_seats']                = 'Maximum Seats: ';
$_['lang_text_available']            = 'Available Seats: ';
$_['lang_text_presenter_tab']        = 'Presenters';
$_['lang_text_add_success']          = 'You have successfully added an event.';
$_['lang_text_add_i_success']        = 'You have successfully added an presenter.';
$_['lang_text_add_s_success']        = 'You have successfully registered someone for this event.';
$_['lang_text_edit_success']         = 'You have successfully edited an event.';
$_['lang_text_edit_i_success']       = 'You have successfully edited an presenter.';
$_['lang_text_delete_success']       = 'You have successfully deleted the selected events.';
$_['lang_text_delete_i_success']     = 'You have successfully deleted the selected presenters.';
$_['lang_text_delete_s_success']     = 'You have successfully deleted the selected people from this event.';
$_['lang_text_monday']               = 'Monday';
$_['lang_text_tuesday']              = 'Tuesday';
$_['lang_text_wednesday']            = 'Wednesday';
$_['lang_text_thursday']             = 'Thursday';
$_['lang_text_friday']               = 'Friday';
$_['lang_text_saturday']             = 'Saturday';
$_['lang_text_sunday']               = 'Sunday';
$_['lang_text_enabled']              = 'Enabled';
$_['lang_text_disabled']             = 'Disabled';
$_['lang_text_add']                  = 'Add to Event';
$_['lang_text_remove']               = 'Remove from List';
$_['lang_text_add_to_event']         = 'You have successfully added this customer to the event.';
$_['lang_text_remove_from_list']     = 'You have successfully removed this customer from the wait list.';
$_['lang_text_add_waitlist_success'] = 'You have successfully added this customer to the events wait list.';
$_['lang_text_duplicate_attendee']   = 'This customer has already been added to the wait list for this event.';
$_['lang_text_add_event_subject']    = 'Event - %s';
$_['lang_text_add_event_message']    = 'You have been added to the event, %s.  You will find the event details below:';
$_['lang_text_add_wait_subject']     = 'Event Wait List - %s';
$_['lang_text_add_wait_message']     = 'You have been added to the wait list for the event, %s.  You will find the event details below:';
$_['lang_text_default']              = 'Default';
$_['lang_text_build']                = 'Build Slug';
$_['lang_text_link']                 = 'Online Event';
$_['lang_text_posted']               = 'Posted';
$_['lang_text_draft']                = 'Draft';
$_['lang_text_instructions']         = '<p>Just some notes on Creating Events.</p><p>When you create a new event, you’ll need to choose between creating a product or page for your event.  The default is a page. You should only create a product if you are charging for the event.</p><p>Anyone wanting to register for an event, must have an account. Make sure you set your visibility properly or your visitors might not see your event. You can target specific customer groups via the visibility menu.</p><p>Once the event is created, you cannot switch from a product to a page or vice-versa. If you want to switch, you must delete the entire event and start over. Keep in mind that this will delete all data for the event including anyone who is already registered.</p>';
$_['lang_text_event']                = 'Default';
$_['lang_text_event-important']      = 'Important';
$_['lang_text_event-info']           = 'Info';
$_['lang_text_event-warning']        = 'Warning';
$_['lang_text_event-inverse']        = 'Inverse';
$_['lang_text_event-success']        = 'Success';
$_['lang_text_event-special']        = 'Special';


// Column
$_['lang_column_event_name']         = 'Event Name';
$_['lang_column_visibility']         = 'Visibility';
$_['lang_column_date_time']          = 'Date/Time';
$_['lang_column_location']           = 'Location';
$_['lang_column_telephone']          = 'Telephone';
$_['lang_column_cost']               = 'Cost';
$_['lang_column_seats']              = 'Seats';
$_['lang_column_filled']             = 'Available';
$_['lang_column_waitlist']           = 'Wait List';
$_['lang_column_presenter']          = 'Presenter';
$_['lang_column_action']             = 'Action';
$_['lang_column_name']               = 'Presenter Name';
$_['lang_column_bio']                = 'Bio';
$_['lang_column_attendee']           = 'Attendee Name';
$_['lang_column_date_added']         = 'Date Added';

// Entry
$_['lang_entry_name']                = 'Event Name:<br><span class="help">Enter a name for this event.</span>';
$_['lang_entry_model']               = 'Model:<br><span class="help">If Create Product is checked a unique product model will be required.</span>';
$_['lang_entry_sku']                 = 'SKU:<br><span class="help">(optional)</span>';
$_['lang_entry_category']            = 'Category:<br><span class="help">Select any product categories your event should fall under.</span>';
$_['lang_entry_store']               = 'Store:';
$_['lang_entry_stock_status']        = 'Out of Stock Status:<br><span class="help">The out of stock message to show for an out of stock event.</span>';
$_['lang_entry_visibility']          = 'Visibility:<br><span class="help">Select the lowest customer group that\'s able to attend this event. Any group with a lower ID will not be able to see the event product.</span>';
$_['lang_entry_event_length']        = 'Event Length:<br><span class="help">The length of your event in hours.<br>Min 1, Max 24.</span>';
$_['lang_entry_event_days']          = 'Event Days:<br><span class="help">The day or days of the week in which your event will occur.</span>';
$_['lang_entry_event_date']          = 'Event Date:';
$_['lang_entry_event_time']          = 'Event Start Time:';
$_['lang_entry_location']            = 'Event Location:<br><span class="help">Enter the address of a live local event.</span>';
$_['lang_entry_link']                = 'Event Link:<br><span class="help">If your event is an Online Event,<br>enter the URL here.</span>';
$_['lang_entry_online']              = 'Online Event:<br><span class="help">If your event is an Online Event,<br>select yes and enter the link below.</span>';
$_['lang_entry_cost']                = 'Event Cost:<br><span class="help">The cost for your event.<br>Enter 0 for FREE event.</span>';
$_['lang_entry_seats']               = 'Maximum Seats:';
$_['lang_entry_presenter_tab']       = 'Presenter Tab Name:<br><span class="help">This can be anything you like, Teacher, Host, Instructor. Default is Presenter.</span>';
$_['lang_entry_presenter']           = 'Event Presenter:<br><span class="help">Select your presenter from the list.</span>';
$_['lang_entry_telephone']           = 'Contact Telephone:<br><span class="help">(optional)</span>';
$_['lang_entry_description']         = 'Event Description:<br><span class="help">Give some details for your event.</span>';
$_['lang_entry_refundable']          = 'Refundable:<br><span class="help">Is your event refundable?</span>';
$_['lang_entry_presenter_name']      = 'Presenter Name:';
$_['lang_entry_bio']                 = 'Presenter Bio:';
$_['lang_entry_customers']           = 'Select an Attendee:<br><span class="help">(autocomplete)</span>';
$_['lang_entry_status']              = 'Event Status:';
$_['lang_entry_page_status']         = 'Page Status:';
$_['lang_entry_slug']                = 'Slug:<br /><span class="help">Do not use spaces instead replace spaces with - and make sure the slug is globally unique.</span>';
$_['lang_entry_is_product']          = 'Create Product:<br><span class="help">Is this event a product? If yes is checked a product will be created.</span>';
$_['lang_entry_event_class']         = 'Calendar Class:<br><span class="help">Select a color to represent this event on the calendar.</span>';

// Button
$_['lang_button_presenters']         = 'Presenters';
$_['lang_button_delete_event']       = 'Delete Event';
$_['lang_button_add_presenter']      = 'Add Presenter';
$_['lang_button_delete_presenter']   = 'Delete Presenter';
$_['lang_button_add_attendee']       = 'Add Attendee';
$_['lang_button_delete_attendee']    = 'Delete Attendee';
$_['lang_button_save']               = 'Save';
$_['lang_button_cancel']             = 'Cancel';
$_['lang_button_clear_list']         = 'Clear Wait List';
$_['lang_button_add_waitlist']       = 'Add to Wait List';

// Error
$_['lang_error_permission']          = 'You do not have permission to modify Events.';
$_['lang_error_warning']             = 'Please correct the errors shown below.';
$_['lang_error_name']                = 'Event Name must be between 1 and 150 characters';
$_['lang_error_model']               = 'Model must be between 1 and 50 characters';
$_['lang_error_event_length']        = 'Event Length must be between 1 and 40 characters';
$_['lang_error_event_date']          = 'You must select a event date and it must be a future date.';
$_['lang_error_event_time']          = 'You must select a event time';
$_['lang_error_location']            = 'Event Location must be between 1 and 200 characters';
$_['lang_error_link']                = 'If your event is online, you must provide an Event URL.';
$_['lang_error_cost']                = 'You must enter a Event Cost';
$_['lang_error_seats']               = 'You must enter the number of Event Seats';
$_['lang_error_presenter']           = 'You must select a Event Presenter';
$_['lang_error_description']         = 'You must enter a Event Description and description must be greater than 25 characters';
$_['lang_error_presenter_name']      = 'Presenter Name must be between 1 and 150 characters';
$_['lang_error_bio']                 = 'You must enter a bio and bio must be greater than 25 characters';
$_['lang_error_attendee_required']   = 'Please select a attendee to add before clicking the Add Attendee button';
$_['lang_error_attendee_exists']     = 'The selected attendee is already registered for this event.';
$_['lang_error_event_days']          = 'You must select at least one day for the event.';
$_['lang_error_slug']                = 'Warning: Slug is required for events.';
$_['lang_error_slug_found']          = 'ERROR: The slug %s is already in use, please set a different one in the input field.';
$_['lang_error_name_first']          = 'ERROR: Please enter a name for your event before attempting to build a slug.';
