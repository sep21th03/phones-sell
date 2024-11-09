// customEditor.js
import {
    ClassicEditor,
    AccessibilityHelp,
    Autosave,
    Bold,
    Essentials,
    Italic,
    Paragraph,
    SelectAll,
    Undo,
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    PasteFromOffice,
    Base64UploadAdapter
} from 'ckeditor5';

export default class CustomEditor {
    constructor() {
        this.editorConfig = {
            toolbar: {
                items: [
                    'undo', 'redo',
                    '|',
                    'selectAll',
                    '|',
                    'bold', 'italic',
                    '|',
                    'imageUpload',
                    '|',
                    'accessibilityHelp'
                ],
                shouldNotGroupWhenFull: false
            },
            placeholder: 'Type or paste your content here!',
            plugins: [
                AccessibilityHelp,
                Autosave,
                Bold,
                Essentials,
                Italic,
                Paragraph,
                SelectAll,
                Undo,
                Image,
                ImageCaption,
                ImageStyle,
                ImageToolbar,
                ImageUpload,
                PasteFromOffice,
                Base64UploadAdapter
            ],
            image: {
                toolbar: [
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'toggleImageCaption',
                    'imageTextAlternative'
                ],
                upload: {
                    types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff']
                }
            }
        };
    }

    // Khởi tạo editor cho một selector cụ thể
    async initEditor(selector, uploadUrl = null, csrfToken = null) {
        try {
            let config = { ...this.editorConfig };
            
            // Thêm cấu hình upload nếu có
            if (uploadUrl && csrfToken) {
                config.simpleUpload = {
                    uploadUrl: uploadUrl,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                };
            }

            const editor = await ClassicEditor.create(
                document.querySelector(selector),
                config
            );

            // Cấu hình style
            editor.ui.view.editable.element.style.width = '100%';
            editor.ui.view.editable.element.style.height = '200px';

            console.log(`Editor ${selector} initialized.`);
            return editor;

        } catch (error) {
            console.error('Editor initialization failed:', error);
            return null;
        }
    }

    // Set nội dung cho editor
    static setContent(editor, content) {
        if (editor) {
            editor.setData(content);
        }
    }

    // Lấy nội dung từ editor
    static getContent(editor) {
        if (editor) {
            return editor.getData();
        }
        return '';
    }

    // Destroy editor instance
    static destroy(editor) {
        if (editor) {
            editor.destroy()
                .then(() => console.log('Editor destroyed successfully.'))
                .catch(error => console.error('Destroy failed:', error));
        }
    }
}