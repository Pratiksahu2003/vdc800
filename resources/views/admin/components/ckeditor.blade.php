@props([
    'name',
    'label',
    'value' => '',
    'id' => null,
    'required' => false,
    'rows' => 12,
    'hint' => true,
])

@php
    $fieldId = $id ?? $name;
@endphp

<div>
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-brand-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <textarea
        name="{{ $name }}"
        id="{{ $fieldId }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 ckeditor-field']) }}
    >{{ old($name, $value) }}</textarea>
    @if($hint)
        <p class="text-xs text-brand-500 mt-1">Rich text — headings, lists, links, tables, and formatting.</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            window.initAdminCkEditors = function (root) {
                if (typeof ClassicEditor === 'undefined') {
                    return;
                }

                const scope = root && root.querySelectorAll ? root : document;
                const fields = scope === document
                    ? scope.querySelectorAll('textarea.ckeditor-field')
                    : scope.querySelectorAll
                        ? scope.querySelectorAll('textarea.ckeditor-field')
                        : [scope].filter((el) => el.matches && el.matches('textarea.ckeditor-field'));

                fields.forEach((el) => {
                    if (!el || el.dataset.ckeditorInit === '1') {
                        return;
                    }

                    if (el.offsetParent === null && scope === document) {
                        return;
                    }

                    el.dataset.ckeditorInit = '1';

                    ClassicEditor.create(el, {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'insertTable', 'blockQuote', '|',
                            'undo', 'redo',
                        ],
                        table: {
                            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
                        },
                    })
                        .then((editor) => {
                            el.ckeditorInstance = editor;
                        })
                        .catch((error) => console.error(error));
                });
            };

            window.syncAdminCkEditors = function (root) {
                const scope = root && root.querySelectorAll ? root : document;
                const fields = scope.querySelectorAll('textarea.ckeditor-field');

                fields.forEach((el) => {
                    if (el.ckeditorInstance) {
                        el.ckeditorInstance.updateSourceElement();
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', () => window.initAdminCkEditors());
            document.addEventListener('submit', (event) => {
                window.syncAdminCkEditors(event.target);
            }, true);
            window.addEventListener('admin-init-ckeditor', (event) => {
                window.initAdminCkEditors(event.detail?.root || document);
            });
        </script>
    @endpush
@endonce
