class Ticket extends Model
{
    protected $fillable = [
        'booking_id',
        'ticket_number',
        'status',
        'checked_in_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
