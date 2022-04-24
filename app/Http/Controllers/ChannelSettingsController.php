<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateChannelRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;

class ChannelSettingsController extends Controller
{
    /**
     * Display the page to edit a channel.
     */
    public function edit(Channel $channel)
    {
        return view('channel.settings.edit', [
            'channel' => $channel
        ]);
    }

    /**
     * Update the details about a channel.
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $this->authorize('update', $channel);

        $attributes = $request->validated();

        $channel->fill($attributes)->save();

        if ($request->file('image')) {
            $request->file('image')->move(storage_path() . '/uploads', $fileId = uniqid(true));

            $this->dispatch(new UploadImage($channel, $fileId));
        }

        return redirect()->route('channels.edit', $channel);
    }
}
