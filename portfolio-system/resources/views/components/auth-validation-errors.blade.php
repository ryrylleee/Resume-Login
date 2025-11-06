@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="error-title" style="color: #dc2626; font-weight: 600; margin-bottom: 8px;">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul style="list-style: none; padding: 0; margin: 0;">
            @foreach ($errors->all() as $error)
                <li style="color: #b91c1c; margin-bottom: 4px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
