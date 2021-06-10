<?php

return [
    'form' => [
        'resource_type_legend' => 'Resource Type',
        'resource_type_label' => 'Please select where the incident occured',
        'resource_url_label' => 'Website information (URL)',
        'content_type_legend' => 'Content Type',
        'content_type_label' => 'Please select the type of content of the incident you wish to report',
        'comments_legend' => 'Incident Description',
        'comments_placeholder' => 'Please describe the incident for better support...',
        'personal_data_legend' => 'Personal data',
        'personal_data_input_false' => 'I prefer staying anonymous (Please note that in case you don’t fill in your personal data, an operator will not be able to contact you for further assistance).',
        'personal_data_input_true' => 'I prefer submitting my personal details (Please note that in case you fill in your personal data, it will be remain strictly confidential).',
        'name_label' => 'Name',
        'name_placeholder' => 'Please write your name',
        'surname_label' => 'Surname',
        'email_label' => 'Email',
        'phone_label' => 'Phone',
        'help_block_personal_data' => 'For communication purposes please provide your email or/and phone.',
        'age_label' => 'Age',
        'gender_label' => 'Gender',
        'g_recaptcha_response_legend' => 'Authenticity check',
        'help_block_required' => 'Required fields.',
        'submit' => 'Submit',
        'title' => "News Title",
        'source' => 'Source of News',
        'upload' => 'Upload',
        'fakenews_intro'=>"Report potential fake-news.",
        'source_type'=>'News Source Type',
        'internet_route'=>'Internet Source Details',
        'source_doc'=> 'Source Document (In full or as parts)',
        'tv_route'=> 'TV Source Details',
        'tv_channel'=> 'TV Channel',
        'tv_prog_title'=> 'TV Program Title',
        'publication_time'=> 'Time Aired',
        'radio_route' => 'Radio Source Datails',
        'radio_station' => 'Radio Station Name',
        'radio_station_freq' => 'Radio Station Frequency',
        'country' => 'Country',
        'town'=> 'Town',
        'newspaper_route' => 'Newspaper Source Details',
        'newspaper_name'=> 'Newspaper Name',
        'page' => 'Specific Page (First page of article)',
        'advertisement_route' => 'Advertisement/Pamphlet Source Details',
        'area_district'=> 'Specific Area',
        'specific_address'=>'Adress',
        'image_recomendation'=> 'For this news source type it is recommended that evidence images are uploaded!',
        'other_route' => 'Other Source Details',
        'specify' => 'Further Specifications of News Source',
        'comments_route' => 'Case Details',
        'publication_date' => 'Date of Publication',
        'upload_images_legend' => 'Image Uploader',
        'image_question' => 'Do you wish to upload evidence image(s)?'
    ],
    'formHelpline' => [
        'intro' => 'Please, submit your request using the following form. Try to fill in all the necessary information for the operator to provide better assistance to your request. Entering your personal data is optional. Therefore your report will remain anonymous unless you wish otherwise. In the case you will be submitting your personal data, they will remain strictly confidential, in accordance with the Personal Data Protection legislation. When submitting your report to this form, additional items, apart from the ones submitted, are not recorded (for example your IP address).',
    ],
    'formHotline' => [
        'intro' => 'Entering your personal data is optional. Therefore, your complaint will remain anonymous, unless you wish otherwise. When submitting your report using this form, additional data will not be recorded (for example your IP address). Personal data will remain strictly confidential, in accordance to the Privacy Policy law.',
    ],
    'formFakenews' => [
        'intro' => "Report potential fake-news.",
    ],
    'chat' => [
        'chat_intro' => 'After filling-in your name, write down and send your message. A service agent will contact you soon.',
        'operator_not_working_hours' => '
                <p>Unfortunately, <strong>the operator is unavailable at this time</strong>.
                The operator may be busy in another chat or out of working hours.</p>
                <p>The working hours of the service are:
                <ul>
                    <li><strong>Monday - Friday, 3.00 pm - 6.00 pm</strong></li>
                </ul>
                </p>
                <p>Please try again later or send your request via: 
                    <ul>
                        <li><strong><a href="https://www.cybersafety.cy/hotline-report">hotline online form</a> or <a href="https://www.cybersafety.cy/helpline-report">helpline online form</a></strong></li>
                        <li><strong><a href="mailto:1480hotline@cyearn.pi.ac.cy">hotline email</a> or <a href="mailto:1480helpline@cyearn.pi.ac.cy">helpline email</a></strong></li>
                    </ul>
                </p>
            ',      
        'enter_name' => 'Enter your name',
        'enter_message' => 'Type your message here...',
        'send_button' => 'Send',
        'operator_busy' => 'Unfortunately, the operator is not available at this time. Please try again later or send your request via the online request form.',
    ],
    'form_errors' => [

    ]
];
