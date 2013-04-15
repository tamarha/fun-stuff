class UsersController < ApplicationController
  def index
  	@users = User.all
  end

  def new
  	@user = User.new
  	@messages = Array.new
  end

  def create
  	@user = User.new(:first_name => params['first_name'], :last_name => params['last_name'], :email_address => params['email_address'], :password => params['password'])
  	@user.save

  	if @user.save
  		@messages = Array.new
  		@messages[0] = "User was successfully created."
  	end
  	respond_to do |format|
  		format.html { render action: "new" }
  		format.json { render json: @messages, status: :unprocessable_entity }
		format.json { render json: @user.errors, status: :unprocessable_entity }
	end
  end

  def edit
    @user = User.find(params[:id])
  	@messages = Array.new
  end

  def update
    @user = User.find(params[:id])
    @user.update_attribute(:first_name, params[:first_name]) if params[:first_name].empty? == false
    @user.update_attribute(:last_name, params[:last_name]) if params[:last_name].empty? == false
    @user.update_attribute(:email_address, params[:email_address]) if params[:email_address].empty? == false
    @user.update_attribute(:password, params[:password]) if params[:password].empty? == false
  end

  def destroy
    @user = User.find(params[:id])
    @user.destroy
  end

end
