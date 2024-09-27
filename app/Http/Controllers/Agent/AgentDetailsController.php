<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AgentDetailsController extends Controller
{
    public function agentDetails()
    {
        $agent_details = AgentDetails::with('country')->get();
        $agent_details->transform(function($agent) {
            $agent->photo = url('images/agents-details/' . $agent->photo);
            $agent->license_image_front = url('images/agents-details/' . $agent->license_image_front);
            $agent->license_image_back = url('images/agents-details/' . $agent->license_image_back);
            $agent->identification_image_front = url('images/agents-details/' . $agent->identification_image_front);
            $agent->identification_image_back = url('images/agents-details/' . $agent->identification_image_back);
            return $agent;
        });
        return response()->json(['data' => $agent_details], 200);
    }
    public function agentRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:agents|max:255',
            'email' => 'required|string|email|unique:agents|max:255',
            'country_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'organization_name' => 'required',
            'organization_email' => 'required|string|email|max:255',
            'license_no' => 'required',
            'license_image_front' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'license_image_back' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'identification_no' => 'required',
            'identification_image_front' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'identification_image_back' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $agent_details = new AgentDetails();
        $agent_details->name = $request->name;
        $agent_details->email = $request->email;
        $agent_details->country_id = $request->country_id;
        $agent_details->address = $request->address;
        $agent_details->city = $request->city;
        $agent_details->post_code = $request->post_code;
        $agent_details->state = $request->state;
        $agent_details->organization_name = $request->organization_name;
        $agent_details->organization_email = $request->organization_email;
        if ($request->hasFile('photo')) { 
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/agents-details');
            $image->move($destinationPath, $name);
            $agent_details->photo = $name;
        }
        $agent_details->license_no = $request->license_no;
        if ($request->hasFile('license_image_front')) { 
            $image = $request->file('license_image_front');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/agents-details');
            $image->move($destinationPath, $name);
            $agent_details->license_image_front = $name;
        }
        if ($request->hasFile('license_image_back')) { 
            $image = $request->file('license_image_back');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/agents-details');
            $image->move($destinationPath, $name);
            $agent_details->license_image_back = $name;
        }
        $agent_details->identification_no = $request->identification_no;
        if ($request->hasFile('identification_image_front')) { 
            $image = $request->file('identification_image_front');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/agents-details');
            $image->move($destinationPath, $name);
            $agent_details->identification_image_front = $name;
        }
        if ($request->hasFile('identification_image_back')) { 
            $image = $request->file('identification_image_back');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/agents-details');
            $image->move($destinationPath, $name);
            $agent_details->identification_image_back = $name;
        }
        $agent_details->save();

        return response()->json(['success' => 'Agent Details Added Successfully'], 200);
    }

    public function agentDetailsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:agents|max:255',
            'email' => 'required|string|email|unique:agents|max:255',
            'country_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'organization_name' => 'required',
            'organization_email' => 'required|string|email|max:255',
            'license_no' => 'required',
            'license_image_front' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'license_image_back' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'identification_no' => 'required',
            'identification_image_front' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'identification_image_back' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $agent_details = AgentDetails::find($request->id);

        // Updating fields
        $agent_details->name = $request->name;
        $agent_details->email = $request->email;
        $agent_details->country_id = $request->country_id;
        $agent_details->address = $request->address;
        $agent_details->city = $request->city;
        $agent_details->post_code = $request->post_code;
        $agent_details->state = $request->state;
        $agent_details->organization_name = $request->organization_name;
        $agent_details->organization_email = $request->organization_email;

        if ($request->hasFile('photo')) {
            if ($agent_details->photo && file_exists(public_path('images/agents-details/' . $agent_details->photo))) {
                unlink(public_path('images/agents-details/' . $agent_details->photo));
            }
            
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/agents-details');
            $image->move($destinationPath, $name);
            $agent_details->photo = $name;
        }

        if ($request->hasFile('license_image_front')) {
            if ($agent_details->license_image_front && file_exists(public_path('images/agents-details/' . $agent_details->license_image_front))) {
                unlink(public_path('images/agents-details/' . $agent_details->license_image_front));
            }
            
            $image = $request->file('license_image_front');
            $name = time() . '_front.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/agents-details'), $name);
            $agent_details->license_image_front = $name;
        }

        if ($request->hasFile('license_image_back')) {
            if ($agent_details->license_image_back && file_exists(public_path('images/agents-details/' . $agent_details->license_image_back))) {
                unlink(public_path('images/agents-details/' . $agent_details->license_image_back));
            }
            
            $image = $request->file('license_image_back');
            $name = time() . '_back.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/agents-details'), $name);
            $agent_details->license_image_back = $name;
        }

        if ($request->hasFile('identification_image_front')) {
            if ($agent_details->identification_image_front && file_exists(public_path('images/agents-details/' . $agent_details->identification_image_front))) {
                unlink(public_path('images/agents-details/' . $agent_details->identification_image_front));
            }
            
            $image = $request->file('identification_image_front');
            $name = time() . '_ident_front.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/agents-details'), $name);
            $agent_details->identification_image_front = $name;
        }

        if ($request->hasFile('identification_image_back')) {
            if ($agent_details->identification_image_back && file_exists(public_path('images/agents-details/' . $agent_details->identification_image_back))) {
                unlink(public_path('images/agents-details/' . $agent_details->identification_image_back));
            }
            
            $image = $request->file('identification_image_back');
            $name = time() . '_ident_back.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/agents-details'), $name);
            $agent_details->identification_image_back = $name;
        }

        $agent_details->save();

        return response()->json(['success' => 'Agent Details Updated Successfully'], 200);
    }
}
