@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'rows' => 12,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-brand-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 ckeditor-field"
    >{{ old($name, $value) }}</textarea>
    <p class="text-xs text-brand-500 mt-1">Rich text editor — supports headings, lists, links, images, and tables.</p>
</div>

@once
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.ckeditor-field').forEach((el) => {
                    if (el.dataset.ckeditorInit) return;
                    el.dataset.ckeditorInit = '1';

                    ClassicEditor.create(el, {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'insertTable', 'blockQuote', '|',
                            'undo', 'redo'
                        ],
                        table: {
                            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                        }
                    }).catch((error) => console.error(error));
                });
            });
        </script>
    @endpush
@endonce
