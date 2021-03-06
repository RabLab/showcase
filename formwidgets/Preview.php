<?php namespace RabLab\Showcase\FormWidgets;

use Backend\Classes\FormWidgetBase;
use System\Models\File;
use System\Classes\SystemException;
use October\Rain\Support\ValidationException;
use RabLab\Showcase\Models\Item;
use Validator;
use Input;
use Response;
use Exception;
use Lang;

/**
 * Preview area for the Create/Edit Item form.
 *
 * @package rablab\showcase
 * @author Fabricio Pereira Rabelo @ by Alexey Bobkov, Samuel Georges
 */
class Preview extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->vars['preview_html'] = Item::formatHtml($this->model->content, true);;

        return $this->makePartial('preview');
    }

    public function init()
    {
        $this->checkUploadItemback();
    }

    protected function checkUploadItemback()
    {
        if (!post('X_BLOG_IMAGE_UPLOAD'))
            return;

        $uploadedFileName = null;

        try {
            $uploadedFile = Input::file('file');

            if ($uploadedFile)
                $uploadedFileName = $uploadedFile->getClientOriginalName();

            $validationRules = ['max:'.File::getMaxFilesize()];
            $validationRules[] = 'mimes:jpg,jpeg,bmp,png,gif';

            $validation = Validator::make(
                ['file_data' => $uploadedFile],
                ['file_data' => $validationRules]
            );

            if ($validation->fails())
                throw new ValidationException($validation);

            if (!$uploadedFile->isValid())
                throw new SystemException('File is not valid');

            $fileRelation = $this->model->content_images();

            $file = new File();
            $file->data = $uploadedFile;
            $file->public = true;
            $file->save();

            $fileRelation->add($file, $this->sessionKey);
            $result = [
                'file' => $uploadedFileName,
                'path' => $file->getPath()
            ];

            $response = Response::make()->setContent($result);
            $response->send();

            die();
        } catch (Exception $ex) {
            $message = $uploadedFileName ? 'Error uploading file "%s". %s' : 'Error uploading file. %s';

            $result = [
                'error' => sprintf($message, $uploadedFileName, $ex->getMessage()),
                'file' => $uploadedFileName
            ];

            $response = Response::make()->setContent($result);
            $response->send();

            die();
        }
    }
}