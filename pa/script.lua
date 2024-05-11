require "lib.moonloader"
local sampev = require 'lib.samp.events'

function main()
	while not isSampAvailable() do wait(0) end
	sampAddChatMessage("[хуй] {d5dedd}Скрипт был успешно загружен. Автор: {01A0E9}Axixe.", 0x01A0E9)

	sampRegisterChatCommand("/return", returnCallBack)
	sampRegisterChatCommand("/exit", exitCommand)

	while true do
		wait(0)
	end
end

function onReceivePacket(ID, BS)
    if(ID == 220) then
        raknetBitStreamIgnoreBits(BS, 8)
        CEF = raknetBitStreamReadInt8(BS)
        if(CEF == 12) then return false end
    end
end