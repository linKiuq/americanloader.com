<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    public function test_contact_form_sends_message_to_digital_mailbox(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'Customer Name',
            'email' => 'customer@example.com',
            'subject' => 'Attachment inquiry',
            'message' => 'I need help choosing an attachment.',
        ]);

        $response
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        Mail::assertSent(ContactMessage::class, function (ContactMessage $mail): bool {
            return $mail->hasTo('sales@typhonmachinery.com')
                && $mail->hasCc('customer@example.com')
                && $mail->hasReplyTo('customer@example.com')
                && $mail->envelope()->subject === '[The Power Loader Contact] Attachment inquiry';
        });
    }

    public function test_contact_form_requires_message_fields_before_sending(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [])
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        Mail::assertNothingSent();
    }

    public function test_contact_page_shows_requested_destination_address(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('sales@typhonmachinery.com')
            ->assertSee('support@typhonmachinery.com')
            ->assertSee('+1 213-214-2203')
            ->assertSee('2522 S Malt Ave. Commerce, CA 90040 United States');
    }
}
