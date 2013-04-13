class UsersController < ApplicationController
  def index
  	@users = User.all
  end

  def new
  	@user = User.new
  	@messages = Array.new()
  end

  def create
  	@user = User.new(:first_name => params['first_name'], :last_name => params['last_name'], :email_address => params['email_address'], :password => params['password'])
  	@user.save

  	if @user.save
  		@messages = Array.new()
  		@messages[0] = "User was successfully created."
  	end
  	respond_to do |format|
  		format.html { render action: "new" }
  		format.json { render json: @messages, status: :unprocessable_entity }
		format.json { render json: @user.errors, status: :unprocessable_entity }
	end

  	# respond_to do |format|
   #    if @user.save
   #      format.html { redirect_to @user, notice: 'User was successfully created.' }
   #      format.json { render json: @user, status: :created, location: @user }
   #    else
   #      format.html { render action: "new" }
   #      format.json { render json: @user.errors, status: :unprocessable_entity }
   #    end
   #  end

  end

end
